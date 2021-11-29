<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            ['name' => 'Administrador', 'description' => 'Acesso total ao sistema'],
            ['name' => 'Funcionário', 'description' => 'Funcionário sem funções administrativas']
        ];
        DB::table('user_types')->insert($types);
    }
}
