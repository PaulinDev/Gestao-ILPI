<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [ ['name' => 'Administrador', 'description' => 'Acesso total'], ['name' => 'Auxiliar', 'description' => 'Acesso parcial'] ];
        DB::table('user_permissions')->insert($permissions);
    }
}
