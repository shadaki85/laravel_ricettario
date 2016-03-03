<?php

use Illuminate\Database\Seeder;

class Ingredient_RecipeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0;$i<20;$i++){
            DB::table('recipe_ingredient')->insert([
                'recipe_id' => rand(1,5),
                'ingredient_id' => rand(1,9),
                'quantity' => rand(1,1000),
        
            ]);
        }
    }
}
