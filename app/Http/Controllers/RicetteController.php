<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Input;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class RicetteController extends Controller
{
    //TODO:
    //Test Search method
    //write Insert, Modify and Delete recipes, their respective views,controllers and routes
    
    
    //checks if the user is an Admin and reroute to the right view.
    public function isAdmin()
    {   
        $users = \App\User::all();
        $user = \App\User::findOrFail(Auth::user()->id);
        if ($user->isAdmin == 1){
            return view('admin',['users'=>$users]);
        } else {
            return view('show',['users'=>$users]);
        }
    }
    
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
        return redirect()->route('home');
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
        return redirect()->route('home');
    }
    
    //--------------------------------------------------------------------------TO TEST
    //will delete the recipe (really?)
    public function deleteRecipe($recipe_id)
    {
        //$recipe = \App\Recipe::find($recipe_id);
        \App\Recipe::destroy($recipe_id);
        return redirect()->route('home');
    }
    
    
    //TODO
    public function processUpdate(Request $request,$recipe_id)
    {
        $recipe = \App\Recipe::findOrFail($recipe_id);
    }
    
    //to finish
    public function processInsert(Request $request)
    {
        if($request->ajax()) {
      $data = Input::all();
      print_r($data);die;
        }
        dd($request);
        //validate user inputs. we need at least 1 ingredient
        if (isset($request->newingr1) || isset($request->ingr1) ){
            $this->validate($request,['title'=>'required','procedure'=>'required']);
        }else{
            //TODO----------------------------------------------------------------------------------------------------------
            dd("return error - TO DO");
        }
        
        dd("STOP! needs to be finished!");
        //$pivot = \App\Recipe_Ingredient::all();
        //dd($pivot);
        
        //this we will need to add in the new recipe
        $userid = Auth::user()->id;
        
        //insert the values!
////////$recipe = \App\Recipe::create(['title'=>$request->title , 'procedure'=>$request->procedure , 'user_id'=>$userid]);
        
        //dd($recipe);

        //let's store all the ingredients needed in $ingredients array (minus the new ingredients)
        $i=1;
        $ingr="ingr".$i;
        while (isset($request->$ingr))
        {
            $ingr="ingr".$i;
            if ($request->$ingr != null)
            {
                $ingredientsNeededInRecipe[] = $request->$ingr;
            }
            $i++;
        }
        
        //let's store all the NEW ingredients added in DB and in $ingredients[] array
        $i=1;
        $newingr="newingr".$i;
        while (isset($request->$newingr))
        {
            $newingr="newingr".$i;
            if ($request->$newingr != null)
            {
////////////////$newIngredients = \App\Ingredient::create(['name'=>$request->$newingr,'type'=>'TODO']);
                $ingredientsNeededInRecipe[] = $request->$newingr;
            }
            $i++;
        }
        
        dd($ingredientsNeededInRecipe);
        //$ingreCheck = \App\Ingredient::all();
        //dd($ingreCheck);
        
        foreach ($ingredientsNeededInRecipe as $ingredientNeededInRecipe){
            
            //find every ingredient's id
            $findIngr = \App\Ingredient::findOrFail($ingredientNeededInRecipe);
            
            //create new record into pivot table recipe-ingredient!
            //$pivot = \App\Recipe_Ingredient::create(['recipe_id'=>$recipe->id,'ingredient_id'=>$findIngr->id,'quantity'=>'TODO']);
        }
    }
    
    
    
    
    
    //expose a json with all the ingredients
    public function exposeJson()
    {
        $ingredients = \App\Ingredient::all();
        return response()->json($ingredients);
    }
}
