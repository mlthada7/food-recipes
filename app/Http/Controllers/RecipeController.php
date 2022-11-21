<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\Method;
use App\Models\Recipe;
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
        // $validated = $request->validate([
        //     // 'title' => 'required|unique:recipes,title',
        //     // 'description' => 'required',
        //     // 'ingredients' => 'required',
        //     // 'methods' => 'required',
        //     // 'image' => 'required|image|file|max:1024',
        // ]);

        // $validated['user_id'] = auth()->user()->id;
        // $validated['image'] = $request->file('image')->store('recipe-images');

        // Recipe::create($validated);

        $request->validate([
            'title' => 'required|unique:recipes,title',
            'description' => 'required',
            'ingredientName' => 'required|array',
            'methodName' => 'required|array',
            // "name.*" => 'required',
            // 'ingredients' => 'required',
            // 'methods' => 'required',
            'image' => 'nullable|image|file|max:1024',
        ]);
        $recipe = new Recipe([
            'title' => $request->title,
            'description' => $request->description,
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

        return redirect()->route('recipes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function show(Recipe $recipe)
    {
        // dd($recipe);
        $ingredients = $recipe->ingredients;
        $methods = $recipe->methods;
        // dd($ingredients);
        return view('recipes.show', [
            'title' => 'Recipe',
            'recipe' => $recipe,
            'ingredients' => $ingredients,
            'methods' => $methods
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