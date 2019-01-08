<?php

use Illuminate\Database\Factories;
use Illuminate\Database\Seeder;
use App\KeyResult;

class KeyResultsTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        KeyResult::truncate();
        KeyResult::unguard();
        factory(KeyResult::class, 36)->create();
        KeyResult::reguard();
    }
}
