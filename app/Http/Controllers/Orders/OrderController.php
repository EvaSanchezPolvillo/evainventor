<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
        function __construct()
    {
        $this->middleware('permission:order-list|order-create|order-edit|order-delete', ['only' => ['index','store']]);
        $this->middleware('permission:order-create', ['only' => ['create','store']]);
        $this->middleware('permission:order-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:order-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $orders = Order::all();
        return view('orders.index', ['orders' => $orders]);
    }

    public function create()
    {
        $orders = Order::all();
        return view('orders.create');
    }

    public function store(Request $request)
    {
        try {
            // Validar la solicitud
            $rules = [
                'status' => 'required|string|min:3|max:255',
                'details' => 'required|array', // Validar que los detalles estén presentes
                'details.*.article_id' => 'required|exists:articles,id', // Validar que los artículos existan
                'details.*.quantity' => 'required|integer|min:1', // Validar cantidad
            ];
    
            $validator = Validator::make($request->all(), $rules);
    
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
    
            // Crear el pedido
            $order = new Order();
            $order->status = $request->input('status');
            $order->user_id = auth()->id(); // Usuario autenticado
            $order->saveOrFail();
    
            // Guardar los detalles del pedido
            foreach ($request->input('details') as $detail) {
                $order->OrderDetail()->create([
                    'article_id' => $detail['article_id'],
                    'quantity' => $detail['quantity'],
                ]);
    
                // Actualizar el stock del artículo
                $article = \App\Models\Article::find($detail['article_id']);
                $article->stock -= $detail['quantity'];
                $article->save();
            }
    
            return redirect()->route('orders.index')->with('success', 'Pedido creado exitosamente.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    
    

    public function update(Request $request, $id)
    {
        try {
            $article = Article::findOrFail($id);
            $article->{$request->column} = $request->value;
            $article->save();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    public function destroy($id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->delete();
            return response()->json(['success' => true]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Pedido no encontrado.'], 404);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            // Cargar el pedido con los detalles y los artículos relacionados
            $order = Order::with(['OrderDetail.article'])->findOrFail($id);
    
            // Preparar los detalles para la respuesta
            $details = $order->OrderDetail->map(function ($detail) {
                return [
                    'article_name' => $detail->article->name ?? 'Artículo no encontrado',
                    'quantity' => $detail->quantity,
                ];
            });
    
            return response()->json([
                'success' => true,
                'order' => [
                    'id' => $order->id,
                    'status' => $order->status,
                    'details' => $details,
                ],
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Pedido no encontrado.'], 404);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    

    



}

