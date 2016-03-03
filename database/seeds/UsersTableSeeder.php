<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $users = ['admin', 'user', 'tizio', 'caio', 'sempronio'];
       foreach($users as $user){
           DB::table('users')->insert([
                'name' => $user,
                'email' => $user.'@gmail.com',
                'password' => bcrypt($user),
                'isAdmin' => rand(0,1),
            ]);
        }
    }
}
