<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(ObjectivesTableSeeder::class);
        $this->call(KeyResultsTableSeeder::class);
        $this->call(PrioritiesTableSeeder::class);
        $this->call(ActionsTableSeeder::class);
    }
}
