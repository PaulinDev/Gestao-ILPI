<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $activities = [['group' => 1, 'name' => 'Almoço'], ['group' => 1, 'name' => 'Jantar'], ['group' => 1, 'name' => 'Café da tarde'], ['group' => 1, 'name' => 'Café da manhã']];
        DB::table('activities')->insert($activities);
    }
}
