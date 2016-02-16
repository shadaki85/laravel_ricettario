<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class RicetteController extends Controller
{
    public function isAdmin()
    {   
        $users = \App\User::all();
        $user = \App\User::findOrFail(Auth::user()->id);
        if ($user->isAdmin == 1){
            return view('admin',['users'=>$users]);
        } else{
            return view('ricette');
        }
    }
    
    public function showall()
    {
        $user = \App\User::findOrFail(Auth::user()->id);
        //la relazione NaN funziona!
        $recipes = \App\Recipe::find(1)->ingredients;
        //dd($recipes);
    }
}
