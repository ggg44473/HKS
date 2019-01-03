<?php

use App\User;
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
        User::truncate(); //清空資料庫
        User::unguard();
        factory(User::class, 3)->create();
        User::reguard(); 
        User::create([
            'name' => 'hks',
            'password' => bcrypt('hkshks'),
            'email' => 'hks@mail.com',
        ]);
    }
}
