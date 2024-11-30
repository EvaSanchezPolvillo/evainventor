<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class ArticleControllerApi extends Controller
{
    public function index()
    {
        $articles = Article::with('subcategory.category')->get();

        $articlesData = $articles->map(function ($article) {
            return [
                'id'=>$article->id,
                'name' => $article->name,
                'stock'=>$article->stock,
                'image'=>$article->image,
                'category' => $article->subcategory->category->name,
                'subcategory' => $article->subcategory->name,
                'available'=>$article->available,
                'visible'=>$article->visible,
                'status'=>$article->status,

            ];
        });

        return response()->json(['articles' => $articlesData]);
    }
    public function store(Request $request)
    {

        try{

            $rules = [
                'nombreArticulo' => 'required|string|min:3|max:255',
                'subcategoria' => 'required',

            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()]);
            }

            $article = new Article();
            $article->name = $request->input('nombreArticulo');
            $article->subcategory_id = $request->subcategoria;
            $article->available = boolval($request->input('available'));
            $article->visible = boolval($request->input('visible'));
            $article->status = $request->input('estado');
            $article->save();
            return response()->json(['success' => true, 'article' => $article]);
        } catch (\Exception $e){

            return response()->json(['success' => false, 'error' => $e->getMessage()]);

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
            $article = Article::findOrFail($id);
            $article->delete();
            return response()->json(['success' => true]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException | \Exception $e) {
            return $e->getMessage();
        }

        return response()->json(['success' => false, 'error' => $e->getMessage()]);
    }
    public function searchByNombre($nombre)
    {
        $articles = Article::where('name', 'like', '%' . $nombre . '%')->get();

        if ($articles->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No articles found containing the given name.']);
        }

        return response()->json(['success' => true, 'articles' => $articles]);
    }

}
