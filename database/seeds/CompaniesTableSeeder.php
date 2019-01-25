<?php

use Illuminate\Database\Factories;
use Illuminate\Database\Seeder;
use App\Company;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::truncate();
        Company::create([
            'name' => 'CMoney 公司',
            'description' => 'Create More Money !',
            'user_id' => 1,
        ]);
    }
}
