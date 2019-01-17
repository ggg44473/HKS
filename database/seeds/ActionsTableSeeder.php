<?php

use Illuminate\Database\Factories;
use Illuminate\Database\Seeder;
use App\Action;

class ActionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Action::truncate();
        Action::unguard();
        factory(Action::class, 1600)->create();
        Action::reguard();
    }
}
