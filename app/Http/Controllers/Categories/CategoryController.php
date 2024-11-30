<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:category-list|category-create|category-edit|category-delete', ['only' => ['index','store']]);
        $this->middleware('permission:category-create', ['only' => ['create','store']]);
        $this->middleware('permission:category-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:category-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', ['categories' => $categories]);
    }

    public function create()
    {
        return view('categories.create');

    }

    public function store(Request $request)
    {
        try{
            //Validación de la categoría antes de introducir los datos
            $rules = [
                'nombreCategoria' => 'required|string|min:3|max:255',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->route('categories.create')
                    ->withErrors($validator)
                    ->withInput();
            }
            //creación de la categoría

            $category = new Category;
            $category->name = $request->input('nombreCategoria');
            $category->available = $request->has('available');
            $category->visible = $request->has('visible');
            $category->save();
            return redirect()->route('categories.index');
        } catch (\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->{$request->column} = $request->value;
            $category->save();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->subcategory()->delete(); // elimina las subcategorías relacionadas
            $response = $category->delete();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException | \Exception $e) {
            return $e->getMessage();
        }
        return ['success' => $response];
    }

    public function countSubcategories($id)
    {
        $subcategories = \App\Models\Subcategory::all();
        $count = $subcategories->where('category_id', $id)->count();
        return response()->json(['count' => $count]);
    }

    public function getSubcategories($id)
    {
        $subcategories = Subcategory::where('category_id', $id)->get();

        return response()->json($subcategories);
    }
    
}
