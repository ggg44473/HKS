<?php

use Illuminate\Database\Seeder;
use App\Priority;

class PrioritiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Priority::truncate();
        Priority::insert([
            'priority' => 'Immediate',
            'color' => 'danger',
        ]);
        Priority::insert([
            'priority' => 'Urgent',
            'color' => 'warning',
        ]);
        Priority::insert([
            'priority' => 'Normal',
            'color' => 'info',
        ]);
        Priority::insert([
            'priority' => 'Low',
            'color' => 'success',
        ]);
        Priority::insert([
            'priority' => 'Postponed',
            'color' => 'dark',
        ]);

    }
}
