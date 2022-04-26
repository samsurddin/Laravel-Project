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

        $this->call([
            PermissionTableSeeder::class,
            CreateAdminUserSeeder::class,
        ]);
    }

    public function runLandlordSpecificSeeders()
    {
        \App\Models\User::factory(10)->create();

        DB::table('plans')->insert([
            ['name' => 'Free', 'description' => 'It\'s just now that I noticed from the video tutorial that Laravel has this foreignId-constrained.', 'features' => 'it returns an error below', 'price' => 500, 'price_yearly'=>650],
            ['name' => 'Business', 'description' => 'Adding additional context, such as documentation links, to your answers is always a good idea.', 'features' => 'Error returned', 'price' => 800, 'price_yearly'=>750],
        ]);

        DB::table('tenants')->insert([
            ['name' => 'KaCom', 'domain' => 'ka.com', 'database' => 'kacom', 'user_id' => 1, 'plan_id'=>2, 'plan_expire_datetime'=>now(),  'created_at'=>now(), 'updated_at'=>now()],
            ['name' => 'AhMad', 'domain' => 'ah.mad', 'database' => 'ahmad', 'user_id' => 2, 'plan_id'=>1, 'plan_expire_datetime'=>now(),  'created_at'=>now(), 'updated_at'=>now()],
            ['name' => 'TenantTest', 'domain' => 'tenant.test', 'database' => 'tenant_test', 'user_id' => 2, 'plan_id'=>2, 'plan_expire_datetime'=>now(),  'created_at'=>now(), 'updated_at'=>now()]
        ]);
        
        $this->call([
            PermissionTableSeeder::class,
            CreateAdminUserSeeder::class,
        ]);
    }
}
