<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("users")->insert([
            'name' => 'Paulo Sérgio',
            'email' => 'teste@gmail.com',
            'post' => 1,
            'type' => 1,
            'gender' => 1,
            'birthdate' => '2000-04-06',
            'userCpf' => '143.170.656-65',
            'userRg' => '16.741.700',
            'permission' => rand(1,2),
            'password' => Hash::make("123")
        ]);
    }
}
