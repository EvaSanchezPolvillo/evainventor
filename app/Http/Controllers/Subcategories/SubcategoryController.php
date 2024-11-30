<?php

namespace App\Http\Controllers\Subcategories;

use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubcategoryController extends Controller

{
    function __construct()
    {
        $this->middleware('permission:subcategory-list|subcategory-create|subcategory-edit|subcategory-delete', ['only' => ['index','store']]);
        $this->middleware('permission:subcategory-create', ['only' => ['create','store']]);
        $this->middleware('permission:subcategory-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:subcategory-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $subcategories = Subcategory::all();
        return view('subcategories.index', ['subcategories' => $subcategories]);
    }
    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('subcategories.create', ['categories' => $categories]);
    }
    public function getSubcategorias($idCategoria) {
        $subcategorias = Subcategory::where('category_id', $idCategoria)->get();
        return response()->json($subcategorias);
    }

    public function store(Request $request)
    {

        try{

            $rules = [
                'nombreSubcategoria' => 'required|string|min:3|max:255',
                'categoria' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->route('subcategories.create')
                    ->withErrors($validator)
                    ->withInput();
            }

            $subcategory = new Subcategory();
            $subcategory->name = $request->input('nombreSubcategoria');
            $subcategory->available = boolval($request->input('available'));
            $subcategory->visible = boolval($request->input('visible'));
            $subcategory->category_id = $request->categoria;
            $subcategory->save();
            return redirect()->route('subcategories.index');
        } catch (\Exception $e){

            return back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $subcategory = Subcategory::findOrFail($id);
            $subcategory->{$request->column} = $request->value;
            $subcategory->save();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {

        try {
            $subcategory = Subcategory::findOrFail($id);
            $response = $subcategory->delete();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException | \Exception $e) {
            return $e->getMessage();
        }
        return ['success' => $response];
    }

}
