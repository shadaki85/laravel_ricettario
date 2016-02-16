<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    
    protected $fillable = ['name','recipe_id'];
    
    public function recipes()
    {
        return $this->belongsToMany('App\Recipe','recipe_ingredient','ingredient_id','recipe_id');
    }
}
