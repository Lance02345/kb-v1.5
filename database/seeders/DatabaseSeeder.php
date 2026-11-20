<?php

namespace Database\Seeders;

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
         $this->call(PermissionSeeder::class);
         $this->call(RoleSeeder::class);
         // UserSeeder inserts the admin with a fixed id of 1, so it must run before any factory users.
         $this->call(UserSeeder::class);
         $this->call(RoleUserSeeder::class);
         $this->call(CountySeeder::class);
         $this->call(CitySeeder::class);
         $this->call(MakeSeeder::class);
         $this->call(ModelSeeder::class);
         $this->call(CarCatalogSeeder::class);
         $this->call(CategorySeeder::class);

         if (app()->environment('local')) {
             \App\Models\User::factory(10)->create();
         }
    }
}
