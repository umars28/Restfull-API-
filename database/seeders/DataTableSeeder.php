<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DataTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();
        \App\Models\Post::factory(20)->create();
        \App\Models\Comment::factory(40)->create();
    }
}
