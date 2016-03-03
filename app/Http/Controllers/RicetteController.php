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
    //write Insert, Modify and Delete recipes, their respective views,controllers and routes
    
    /****************************************************
    * ADMIN SECTION
    ****************************************************/
    
    //admin user-list page
    public function adminHome()
    {   
        $users = \App\User::all();
        return view('admin',['users'=>$users]);
    }
        
     //change from 'user' to 'admin' and vice-versa
    public function changePerm($user_id)
    {
        $user = \App\User::findOrFail($user_id);
        if ($user->isAdmin == 0)
        {
            $user->isAdmin = 1;
        }
        else 
        {
            $user->isAdmin = 0;
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
        $users = \App\User::all();

        return view('show',['users'=>$users]);
    }
    
    //returns the single $recipe_id recipe.
    public function showOne($recipe_id)
    {
        $user = \App\User::findOrFail(Auth::user()->id);
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
    
    //TODO
    public function updateProcess(Request $request)
    {
        
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
    
    //to finish
    public function search($search_input)
    {
        $titlesMatches = \App\Recipe::where('title','like','%($search_input)%');
        $proceduresMatches = \App\Recipe::Where('procedure','like','%($search_input)%');
        $usersMatches = \App\Recipe::Where('name','like','%($search_input)%');
        
        dd($titlesMatches);
        
        //write the view!----------------------------------------------------------------------------------------------------------------------
        //return view('results',['titlesMatches'=>$titlesMatches,'proceduresMatches'=>$proceduresMatches]);
    }
    
    //expose a json with all the ingredients
    public function exposeJson()
    {
        $ingredients = \App\Ingredient::all();
        return response()->json($ingredients);
    }
}
