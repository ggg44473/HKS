<?php

use Illuminate\Database\Factories;
use Illuminate\Database\Seeder;
use App\Keyresult;

class Key_resultTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('key_results')->truncate();
        Keyresult::unguard();
        factory(Keyresult::class, 36)->create();
        Keyresult::reguard();
    }
}
