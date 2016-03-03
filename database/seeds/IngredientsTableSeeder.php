<?php

use Illuminate\Database\Seeder;

class IngredientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ingrs = [
                    'peperoni'=>'gr',
                    'pomodori'=>'gr',
                    'patate'=>'gr',
                    'pollo'=>'gr',
                    'acqua'=>'cl',
                    'sale' =>'gr',
                    'pepe' =>'gr',
                    'fragole' =>'gr',
                    'pesche' =>'gr',
                 ];

        foreach($ingrs as $name => $type){
            DB::table('ingredients')->insert([
               'name' => $name,
               'type' => $type,
            ]);
        }
    }
}
