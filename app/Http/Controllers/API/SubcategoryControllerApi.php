<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class SubcategoryControllerApi extends Controller

{
    public function index()
    {
        $subcategories = Subcategory::all();
        return response()->json(['subcategories' => $subcategories]);
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
                return response()->json(['success' => false, 'errors' => $validator->errors()]);
            }
            $subcategory = new Subcategory();
            $subcategory->name = $request->input('nombreSubcategoria');
            $subcategory->available = boolval($request->input('available'));
            $subcategory->visible = boolval($request->input('visible'));
            $subcategory->category_id = $request->categoria;
            $subcategory->save();
            return response()->json(['success' => true, 'subcategories' => $subcategory]);
        } catch (\Exception $e){
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
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
