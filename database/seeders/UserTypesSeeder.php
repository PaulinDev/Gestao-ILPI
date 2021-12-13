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
            ['name' => 'Funcionário', 'description' => 'Funcionário/Administrador'],
            ['name' => 'Responsavél', 'description' => 'Responsável por um utente'],
        ];
        DB::table('user_types')->insert($types);
    }
}
