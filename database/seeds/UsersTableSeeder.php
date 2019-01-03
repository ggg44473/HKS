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
        \App\User::truncate(); //清空資料庫
        \App\User::create([
            'name' => 'hks',
            'password' => bcrypt('hkshks'),
            'email' => 'hks@mail.com',
        ]);
    }
}
