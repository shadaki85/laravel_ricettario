<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Input;
use Validator;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class RicetteController extends Controller
{
    //TODO:
    //Test Search method
    //Write edit recipes method and Testing 
    //Write a method to show all the ingredients in database and the way to edit them (admin only) - view and routing also
    
    /****************************************************
    * ADMIN SECTION
    ****************************************************/
    
    //admin user-list page
    public function adminHome()
    {   
        $users = \App\User::all()->sortBy('id');
        return view('admin',['users'=>$users]);
    }
        
     //changes from 'user' to 'admin' and vice-versa and modifies name
    public function modifyUser(Request $request, $user_id)
    {
        $user = \App\User::findOrFail($user_id);
        
        $user->isAdmin = $request->isAdmin;

        if(isset($request->name) && $request->name != $user->name && $request->name != "")
        {
            $user->name = $request->name;
        }
        
        $user->save();
        return redirect()->route('admin');
    }
    
    //deletes the selected user (and his recipes) :(
    public function deleteUser($user_id)
    {
        
        $user = \App\User::findOrFail($user_id);
        if (!$user->recipes->isEmpty())
        {
            foreach ($user->recipes as $recipe){
                \App\Recipe::destroy($recipe->id);
            }
            \App\User::destroy($user_id);
        }
        else
        {
            \App\User::destroy($user_id);
        }
        return redirect()->route('admin');
    }
    
    /****************************************************
    * RECIPES SECTION
    ****************************************************/
    
    //user landing page
    //returns a collection of ALL the recipes. ($recipes)
    public function showAll()
    {
        $recipes = \App\Recipe::all();
        $users = \App\User::all();
        return view('show',['users'=>$users,'recipes'=>$recipes]);
    }
    
    //returns the single $recipe_id recipe.
    public function showOne($recipe_id)
    {
        $recipe = \App\Recipe::find($recipe_id);
        return view('showone',['recipe'=>$recipe]);
    }

    //will delete the recipe (really?)
    public function deleteRecipe($recipe_id)
    {
        \App\Recipe::destroy($recipe_id);
        return redirect()->route('recipes');
    }
    
    //pass the $recipe to edit to the view
    public function updateRecipe($recipe_id)
    {
        $recipe = \App\Recipe::findOrFail($recipe_id);
        return view('edit',['recipe'=>$recipe]);
    }
    
    //edits the current recipe with new title,procedure and ingredients
    public function processUpdate(Request $request,$recipe_id)
    {
        //validate user inputs. we need at least 1 ingredient, title and procedure
        $rules = [ 
                'data.title' => 'required',
                'data.procedure' => 'required',
                'data.ingred' => 'required_without:data.newIngred',
            ];
            
        $messages = [
                'data.title.required' => 'Il titolo è richiesto!',
                'data.procedure.required'  => 'La procedura per la preparazione della ricetta è obbligatoria!',
                'data.ingred.required_without' => 'E necessario almeno un ingrediente!',
            ];
        $validator = Validator::make($request->all(), $rules, $messages);
        $errors = $validator->errors();
        $errors =  json_decode($errors);
        
        if ($validator->fails()) {
            return response()->json([
            'message' => $errors
            ], 422);
        }
        
        //this we will need if the editing user is not the owner (admin editing)
        $userid = Auth::user()->id;

        $recipe = \App\Recipe::findOrFail($recipe_id);       
        
        //insert the new values!
        $recipe->title = $request->data['title'];
        $recipe->procedure = $request->data['procedure'];
        $recipe->user_id = $userid;
        $recipe->save();
        // removes old records recipe_ingredient from db
        // creates new record into pivot table recipe-ingredient for each ingredient needed!
        $oldIngrInPivot = \App\Recipe_Ingredient::where('recipe_id', '=' ,$recipe_id)->get();
        foreach($oldIngrInPivot as $oldIngr)
        {
            \App\Recipe_Ingredient::destroy($oldIngr->id);
        }
        foreach ($request->data['ingred'] as $ingr){
            $ingrInDb = \App\Ingredient::where('name','=',$ingr['name'])->first();
            $pivot = \App\Recipe_Ingredient::create(['recipe_id'=>$recipe_id,'ingredient_id'=>$ingrInDb->id,'quantity'=>$ingr['quantity']]);
        }
    }
    
    //Inserts title, procedure, user id and ingredients needed.
    public function processInsert(Request $request)
    {
        //validate user inputs. we need at least 1 ingredient, title and procedure
        $rules = [ 
                'data.title' => 'required',
                'data.procedure' => 'required',
                'data.ingred' => 'required_without:data.newIngred',
            ];
            
        $messages = [
                'data.title.required' => 'Il titolo è richiesto!',
                'data.procedure.required'  => 'La procedura per la preparazione della ricetta è obbligatoria!',
                'data.ingred.required_without' => 'E necessario almeno un ingrediente!',
            ];
        $validator = Validator::make($request->all(), $rules, $messages);
        $errors = $validator->errors();
        $errors =  json_decode($errors);
        
        if ($validator->fails()) {
            return response()->json([
            'message' => $errors
            ], 422);
        }


        //this we will need to add in the new recipe
        $userid = Auth::user()->id;

       
        //insert the recipe values!
        $recipe = \App\Recipe::create(['title'=>$request->data['title'] , 'procedure'=>$request->data['procedure'] , 'user_id'=>$userid]);


        //create new record into pivot table recipe-ingredient for each ingredient needed!
        foreach ($request->data['ingred'] as $ingr){
            $ingrInDb = \App\Ingredient::where('name','=',$ingr['name'])->first();
            $pivot = \App\Recipe_Ingredient::create(['recipe_id'=>$recipe->id,'ingredient_id'=>$ingrInDb->id,'quantity'=>$ingr['quantity']]);
        }
    }
    
    //insert new ingredient into DB
    public function processInsertIngredient(Request $request)
    {
        $newIngredientInsert = \App\Ingredient::create(['name'=>$request->newingr['name'],'type'=>$request->newingr['type']]);
    }
    
    
    /****************************************************
    * SEARCH AND JSON SECTION
    ****************************************************/
    
    //search into the database for user input
    public function search(Request $request)
    {
        //validate user input.
        $rules = [ 
                'search' => 'min:3|required',
            ];
            
        $messages = [
                'search.min' => 'Devi inserire almeno 3 caratteri da cercare!',
                'search.required' => 'Devi inserire almeno 3 caratteri da cercare!',
            ];
        $validator = Validator::make($request->all(), $rules, $messages);
        $errors = $validator->errors();
        
        if ($validator->fails()) {
            return redirect()->route('recipes')->withErrors($errors);
        }
        
        //queries 
        $recipesMatches = \App\Recipe::where('title','like','%'.($request->search).'%')
                                     ->orWhere('procedure','like','%'.($request->search).'%')
                                     ->get();
        $usersMatches = \App\User::where('name','like','%'.($request->search).'%')
                                     ->orWhere('email','like','%'.($request->search).'%')
                                     ->get();
        $ingredientsMatches = \App\Ingredient::where('name','like','%'.($request->search).'%')
                                     ->get();
        
        $searchInput= $request->search;
        
        //highlight what we have found!
        foreach($ingredientsMatches as $ingredient){
            if (stripos($ingredient->name,$searchInput) !== false)
            {            
                $ingredient->name = substr_replace($ingredient->name,('<b class="highlight">'.$searchInput.'</b>'),stripos($ingredient->name,$searchInput),strlen($searchInput));
            } 
        }
        
        foreach($recipesMatches as $recipe){
            if (stripos($recipe->title,$searchInput) !== false)
            {            
                $recipe->title = substr_replace($recipe->title,('<b class="highlight">'.$searchInput.'</b>'),stripos($recipe->title,$searchInput),strlen($searchInput));
            }
            if (stripos($recipe->procedure,$searchInput) !== false)
            {
                $recipe->procedure = substr_replace($recipe->procedure,('<b class="highlight">'.$searchInput.'</b>'),stripos($recipe->procedure,$searchInput),strlen($searchInput));
                
            }
        }
        
        foreach($usersMatches as $user){
            if (stripos($user->name,$searchInput) !== false)
            {            
                $user->name = substr_replace($user->name,('<b class="highlight">'.$searchInput.'</b>'),stripos($user->name,$searchInput),strlen($searchInput));
            }
            if (stripos($user->email,$searchInput) !== false)
            {            
                $user->email = substr_replace($user->email,('<b class="highlight">'.$searchInput.'</b>'),stripos($user->email,$searchInput),strlen($searchInput));
            }
        }
        
        return view('results',['ingredientsMatches'=>$ingredientsMatches,'recipesMatches'=>$recipesMatches,'usersMatches'=>$usersMatches,'searchInput'=>$request->search]);
    }
    
    //expose a json with all the ingredients
    public function exposeJson()
    {
        $ingredients = \App\Ingredient::all();
        return response()->json($ingredients);
    }
    
    /****************************************************
    * INGREDIENTS SECTION
    ****************************************************/   
    public function showIngredients()
    {
        $ingredients = \App\Ingredient::all();
        return view('ingredients',['ingredients'=>$ingredients]);
    }
    
    public function deleteIngredient($ingredient_id)
    {
        \App\Ingredient::destroy($ingredient_id);
        return redirect()->route('ingredients');
    }
    
    public function modifyIngredient(Request $request, $ingredient_id)
    {
        $ingr = \App\Ingredient::findOrFail($ingredient_id);
        
        if ($request->name != "")
        {
            $ingr->name = $request->name;
        }
        $ingr->type = $request->type;
        $ingr->save();
        return redirect()->route('ingredients');
    }
}
