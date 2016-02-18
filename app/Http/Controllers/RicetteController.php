<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class RicetteController extends Controller
{
    //TODO:
    //write a Search method
    //write Insert, Modify and Delete recipes, their respective views,controllers and routes
    //write single recipe view
    //finish admin page (view and methods to modify users)
    
    
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
    public function showall()
    {
        $users = \App\User::all();

        return view('show',['users'=>$users]);
    }
    
    //returns the single $recipe_id recipe.
    public function showone($recipe_id)
    {
        $user = \App\User::findOrFail(Auth::user()->id);
        
        $recipe = \App\Recipe::find($recipe_id)->ingredients;
        
        dd($recipe);
        
        //write the view!
        //return view('showone',['recipe'=>$recipe]);
    }
}
