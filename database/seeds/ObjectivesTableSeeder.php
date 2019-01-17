<?php

use Illuminate\Database\Seeder;
use App\Objective;

class ObjectivesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Objective::truncate();
        Objective::unguard();
        factory(Objective::class, 400)->create();
        Objective::reguard();
    }
}
