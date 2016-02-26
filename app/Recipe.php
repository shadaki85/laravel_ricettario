<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = ['title','procedure','user_id'];
    
    public function ingredients()
    {
        return $this->belongsToMany('App\Ingredient','recipe_ingredient','recipe_id','ingredient_id')->withPivot('quantity');
    }
    
    public function user()
    {
        return $this->belongsTo('App\User','recipe_id');
    }
}
