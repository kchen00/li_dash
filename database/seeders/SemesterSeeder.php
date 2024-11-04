<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Semester;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Semester::create([
            'semester_number' => 1,
            'start_year' => 2023,
            'end_year' => 2024,
        ]);

        Semester::create([
            'semester_number' => 1,
            'start_year' => 2024,
            'end_year' => 2025,
        ]);

        Semester::create([
            'semester_number' => 2,
            'start_year' => 2022,
            'end_year' => 2023,
        ]);

        Semester::create([
            'semester_number' => 2,
            'start_year' => 2023,
            'end_year' => 2024,
        ]);
    }
}
