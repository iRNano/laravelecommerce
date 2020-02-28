<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
        	'name' => 'Admin Three',
        	'email' => 'adminthree@gmail.com',
        	'password' => bcrypt('password'),
        	'isAdmin' => 1,
        	'created_at' => Carbon::now()
        ]);
    }
}
