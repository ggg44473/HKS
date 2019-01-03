<?php

use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
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
