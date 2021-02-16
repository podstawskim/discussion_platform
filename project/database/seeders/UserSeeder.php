<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'John Doe',
            'email' => 'john.doe@gmail.com',
            'password' => bcrypt('secret'),
        ]);
        DB::table('users')->insert([
            'name' => 'Jane Doe',
            'email' => 'jane.doe@gmail.com',
            'password' => bcrypt('passwd'),
        ]);
        DB::table('users')->insert([
            'name' => 'Baby Doe',
            'email' => 'baby.doe@gmail.com',
            'password' => bcrypt('gugugaga'),
        ]);
    }
}
