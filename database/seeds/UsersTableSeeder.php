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
            'name' => 'Ken',
            'password' => bcrypt('hkshks'),
            'email' => 'GoalCareHKS@gmail.com',
            'position' => '老闆',
            'company_id' => 1,
            'email_verified_at' => now(),
        ]);
        User::create([
            'name' => 'Tiffany',
            'password' => bcrypt('hkshks'),
            'email' => 'ggg44473@gmail.com',
            'position' => '專案經理',
            'email_verified_at' => now(),
        ]);
        User::create([
            'name' => 'Stan',
            'password' => bcrypt('hkshks'),
            'email' => 'huangkaiyun1@gmail.com',
            'position' => '工程師',
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
