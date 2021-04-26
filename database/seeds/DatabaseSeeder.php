<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use CreatyDev\Domain\Users\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //  $this->call(PlanTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(CategoryTableSeeder::class);

        
    }
}
