<?php


use Illuminate\Database\Factories;
use Illuminate\Database\Seeder;
use App\Objective;

class ObjectiveTableSeeder extends Seeder
{


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('objectives')->truncate();
        Objective::unguard();
        factory(Objective::class, 12)->create();
        Objective::reguard();
    }
}
