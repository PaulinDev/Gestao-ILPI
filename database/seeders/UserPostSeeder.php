<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = [[
            'name' => 'Enfermeiro',
            'description' => 'enfermeiro auxiliar',
        ], [
            'name' => 'Responsável',
            'description' => 'Responsável por um utente',
        ],];

        DB::table("user_posts")->insert($posts);
    }
}
