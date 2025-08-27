<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkillsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // You can insert multiple skills like this
        DB::table('skills')->insert([
            ['name' => 'PHP', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'JavaScript', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Laravel', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Vue.js', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'CSS', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bootstrap', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ajax', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'API', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'HTML', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
