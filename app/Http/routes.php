<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/


//If not logged-in, you are redirected to login/register page.
Route::group(['middleware' => ['web']], function () {
    Route::auth();
});


//if logged-in (thanks to middleware auth) and calling root path (/) returns home routing
//home route uses isAdmin method to check user type and redirect.
Route::group(['middleware' => ['web','auth']], function () {
    Route::get('/', function(){
        return redirect()->route('home');
    });
    Route::get('/home',['as'=>'home','uses'=>'RicetteController@isAdmin']);
    
    //recipes routing
    Route::get('/recipes',['as'=>'recipes','uses'=>'RicetteController@showAll']);
    Route::get('/recipes/new',function(){
        return view('create');
    });
    Route::post('/recipes',['as'=>'create.process','uses'=>'RicetteController@processInsert']);
    
    //single recipe routing
    Route::get('/recipes/{recipe_id}',['as'=>'recipes','uses'=>'RicetteController@showOne']);
    Route::get('/recipes/{recipe_id}/edit',function(){
        return view('edit');
    });    
    Route::put('/recipes/{recipe_id}',['as'=>'modifyProcess','uses'=>'RicetteController@processUpdate']);
    
    //search route
    Route::get('/search/{search_input}',['as'=>'search','uses'=>'RicetteController@search']);
    
    //admin routing for manipulating users
    Route::put('/user/{user_id}',['as'=>'user','uses'=>'RicetteController@changePerm']);
    Route::delete('/user/{user_id}',['as'=>'user','uses'=>'RicetteController@deleteUser']);
    
    //api
    Route::get('/api/ingredients',['as'=>'getIngredients','uses'=>'RicetteController@exposeJson']);
});    
