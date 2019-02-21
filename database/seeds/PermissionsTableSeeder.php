<?php

use Illuminate\Database\Seeder;
use App\Permission;
use App\Company;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::truncate();
        Permission::create([
            'user_id'=>1,
            'model_type'=>Company::class,
            'model_id'=>1,
            'role_id'=>1
        ]);
        // collect(range(5, 124))->each(function (int $userId) {
        //     factory(Permission::class)->create([
        //         'user_id' => $userId,
        //         'model_type'=>Company::class,
        //         'model_id'=>1,
        //         'role_id'=>4
        //     ]);
        // });
    }
}
