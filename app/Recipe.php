<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = ['title','procedure','ingredient_id'];
    
    public function ingredients()
    {
        return $this->belongsToMany('App\Ingredient','recipe_ingredient','recipe_id','ingredient_id');
    }
}
