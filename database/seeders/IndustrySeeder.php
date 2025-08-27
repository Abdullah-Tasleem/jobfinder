<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IndustrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $industries = [
            ['name' => 'Information Technology'],
            ['name' => 'Web Development'],
            ['name' => 'Software Engineering'],
            ['name' => 'Data Science'],
            ['name' => 'Cybersecurity'],
            ['name' => 'Digital Marketing'],
            ['name' => 'E-commerce'],
            ['name' => 'Artificial Intelligence'],
            ['name' => 'Cloud Computing'],
            ['name' => 'Blockchain'],
            ['name' => 'Education'],
            ['name' => 'Telecommunications'],
        ];

        DB::table('industries')->insert($industries);
    }
}
