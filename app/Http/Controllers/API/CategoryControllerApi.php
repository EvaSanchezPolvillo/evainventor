<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class CategoryControllerApi extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return response()->json(['categories' => $categories]);}

    public function store(Request $request)
    {
        try{
            //Validación de la categoría antes de introducir los datos
            $rules = [
                'nombreCategoria' => 'required|string|min:3|max:255',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()]);
            }
            //creación de la categoría

            $category = new Category;
            $category->name = $request->input('nombreCategoria');
            $category->available = $request->has('available');
            $category->visible = $request->has('visible');
            $category->save();
            return response()->json(['success' => true, 'categories' => $category]);
        } catch (\Exception $e){
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
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
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
        return response()->json(['success' => true]);
    }

}
