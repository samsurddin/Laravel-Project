<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Multitenancy\Models\Tenant;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Tenant::checkCurrent()
           ? $this->runTenantSpecificSeeders()
           : $this->runLandlordSpecificSeeders();
    }

    public function runTenantSpecificSeeders()
    {
        \App\Models\User::factory(10)->create();
    }

    public function runLandlordSpecificSeeders()
    {
        \App\Models\User::factory(10)->create();
        DB::table('tenants')->insert([
            ['name' => 'KaCom', 'domain' => 'ka.com', 'database' => 'kacom'],
            ['name' => 'AhMad', 'domain' => 'ah.mad', 'database' => 'ahmad']
        ]);
    }
}
