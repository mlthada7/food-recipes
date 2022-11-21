<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Method;
use App\Models\Recipe;
use App\Models\Ingredient;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recipes = Recipe::latest()->paginate(6);
        return view('recipes.index', [
            'title' => 'Recipes',
            'recipes' => $recipes
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('recipes.create', [
            'title' => 'Create Recipe'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:recipes,title',
            'description' => 'required',
            'ingredientName' => 'required|array',
            'methodName' => 'required|array',
            'image' => 'required|image|file|max:1024',
        ]);
        $recipe = new Recipe([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $request->file('image')->store('recipe-images'),
            'user_id' => auth()->user()->id,
        ]);
        $recipe->save();

        foreach ($request->ingredientName as $key => $value) {
            $ingredients = new Ingredient([
                'name' => $value,
                'recipe_id' => $recipe->id
            ]);
            $ingredients->save();
        }

        foreach ($request->methodName as $key => $value) {
            $methods = new Method([
                'name' => $value,
                'recipe_id' => $recipe->id
            ]);
            $methods->save();
        }

        return redirect()->route('recipes.index')->with(['success' => 'Resep berhasil dibuat']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function show(Recipe $recipe)
    {
        $ingredients = $recipe->ingredients;
        $methods = $recipe->methods;

        return view('recipes.show', [
            'title' => 'Recipe',
            'recipe' => $recipe,
            'ingredients' => $ingredients,
            'methods' => $methods
        ]);
    }

    public function likeRecipe(Request $request)
    {
        $data['user_id'] = auth()->user()->id;
        $data['recipe_id'] = $request->recipe_id;

        $recipe = Recipe::where('id', $data['recipe_id'])->first();

        // validasi jika user sudah pernah like resep
        if (Like::where('user_id', $data['user_id'])->where('recipe_id', $data['recipe_id'])->first()) {
            return response()->json([
                'status' => 'failed',
                'message' => "Anda sudah menyukai resep <b>$recipe->title</b> :)"
            ]);
        }

        $like = new Like([
            'user_id' => $data['user_id'],
            'recipe_id' => $data['recipe_id'],
        ]);
        $like->save();

        // $count = Like::where('recipe_id', $like->recipe_id)->count();
        return response()->json([
            'status' => 'success',
            'message' => "Terimakasih sudah menyukai resep <b>$recipe->title</b> :)"
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function edit(Recipe $recipe)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Recipe $recipe)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recipe $recipe)
    {
        //
    }
}