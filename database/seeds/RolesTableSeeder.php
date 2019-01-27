<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::truncate();
        Role::create([
            'name' => '管理員'
        ]);
        Role::create([
            'name' => '一般成員'
        ]);
    }
}
