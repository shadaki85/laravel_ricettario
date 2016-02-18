<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecipeIngredientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipe_ingredient', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ingredient_id');
            $table->integer('recipe_id');
            $table->integer('quantity');
            //type: 0 => g, 1 => cl, 2 => units.
            $table->integer('type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('recipe_ingredient');
    }
}
