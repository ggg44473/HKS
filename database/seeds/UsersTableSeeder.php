<?php

use App\User;
use Illuminate\Database\Seeder;
use App\Permission;

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
            'email_verified_at' => now(),
        ]);
        User::create([
            'name' => 'Karen',
            'password' => bcrypt('hkshks'),
            'email' => 'huangkaiyun1@gmail.com',
            'position' => '總經理',
            'email_verified_at' => now(),
        ]);
        User::create([
            'name' => 'Sean',
            'password' => bcrypt('hkshks'),
            'email' => 'ggg44473@gmail.com',
            'position' => '總經理小弟',
            'email_verified_at' => now(),
        ]);
        User::create([
            'name' => 'Hilton',
            'password' => bcrypt('hkshks'),
            'email' => 'h20110213@gmail.com',
            'position' => '總經理特助',
            'email_verified_at' => now(),
        ]);
        User::unguard();
        // factory(User::class, 120)->create();
        User::reguard();

    }
}
