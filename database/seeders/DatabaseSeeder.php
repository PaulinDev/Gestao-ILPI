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
        $this->call(UserPostSeeder::class);
        $this->call(UserTypesSeeder::class);
        $this->call(UserPermissionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CivilSeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(EducationSeeder::class);
        $this->call(GenderSeeder::class);
        $this->call(OccupationSeeder::class);
        $this->call(SituationSeeder::class);
        $this->call(GroupActivitySeeder::class);
        $this->call(ActivitySeeder::class);
        \App\Models\Patient::factory(200)->create();
        \App\Models\EventActivity::factory(200)->create();
    }
}
