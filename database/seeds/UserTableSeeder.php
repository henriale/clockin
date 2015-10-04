<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         User::create([
             'name' => 'Admin',
             'email' => 'alexandreh.araujo@gmail.com',
             'username' => 'admin',
             'password' => bcrypt('123qwe')
         ]);
    }
}
