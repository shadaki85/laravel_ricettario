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

/****************************************************
* UNLOGGED USERS SECTION
****************************************************/
Route::group(['middleware' => ['web']], function () {
    Route::auth();
});


/****************************************************
* LANDING SECTION
****************************************************/
Route::group(['middleware' => ['web','auth']], function () {
    Route::get('/', function(){
        return redirect()->route('recipes');
    });

    /****************************************************
    * RECIPES SECTION
    ****************************************************/
    Route::get('/recipes',['as'=>'recipes','uses'=>'RicetteController@showAll']);
    Route::get('/recipes/new',function(){
        return view('create');
    });
    Route::post('/recipes',['as'=>'create.process','uses'=>'RicetteController@processInsert']);
    
    //test
    Route::post('/newingredientinsert',['as'=>'new.ingredient','uses'=>'RicetteController@processInsertIngredient']);
    
    /****************************************************
    * SINGLE RECIPE SECTION
    ****************************************************/
    Route::get('/recipes/{recipe_id}',['as'=>'recipe','uses'=>'RicetteController@showOne']);
    Route::get('/recipes/{recipe_id}/edit',['as'=>'recipe','uses'=>'RicetteController@updateRecipe']);    
    Route::put('/recipes/{recipe_id}',['as'=>'recipe','uses'=>'RicetteController@processUpdate']);
    Route::delete('/recipes/{recipe_id}',['as'=>'recipe','uses'=>'RicetteController@deleteRecipe']);
    
    
    /****************************************************
    * SEARCH AND API SECTION
    ****************************************************/
    Route::get('/search/{search_input}',['as'=>'search','uses'=>'RicetteController@search']);
    Route::get('/api/ingredients',['as'=>'getIngredients','uses'=>'RicetteController@exposeJson']);
    
    
    /****************************************************
    * ADMIN SECTION
    ****************************************************/
    Route::group(['middleware' => 'isadmin'], function(){
        Route::get('/home/admin',['as'=>'home.admin','uses'=>'RicetteController@adminHome']);
        Route::put('/user/{user_id}',['as'=>'user','uses'=>'RicetteController@changePerm']);
        Route::delete('/user/{user_id}',['as'=>'user','uses'=>'RicetteController@deleteUser']);
    });
});    
