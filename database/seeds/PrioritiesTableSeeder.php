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
            'priority' => 'Postponed',
            'color' => 'dark',
        ]);
        Priority::insert([
            'priority' => 'Low',
            'color' => 'success',
        ]);
        Priority::insert([
            'priority' => 'Normal',
            'color' => 'info',
        ]);
        Priority::insert([
            'priority' => 'Immediate',
            'color' => 'warning',
        ]);
        Priority::insert([
            'priority' => 'Urgent',
            'color' => 'danger',
        ]);
    }
}
