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
        User::create([
            'name' => 'Enyun',
            'password' => bcrypt('hkshks'),
            'email' => 'GoalCareHKS@gmail.com',
            'position' => '董事長',
            'company_id' => 1, 
        ]);
        User::create([
            'name' => 'Karen',
            'password' => bcrypt('hkshks'),
            'email' => 'huangkaiyun1@gmail.com',
            'position' => '總經理',
        ]);
        User::unguard();
        factory(User::class, 120)->create();
        User::reguard(); 
        
    }
}
