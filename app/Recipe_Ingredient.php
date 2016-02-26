<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe_Ingredient extends Model
{
   protected $table = "recipe_ingredient";
   
   protected $fillable = ['ingredient_id','recipe_id','quantity'];
}
