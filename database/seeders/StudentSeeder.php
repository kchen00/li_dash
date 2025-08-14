<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Semester;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // read csv files from directory storage\. to seed the database

        // Path to the CSV file
        $filePath = storage_path('data\students.csv');

        if (($handle = fopen($filePath, 'r')) !== false) {
            // Skip the header row
            fgetcsv($handle);


            // Read each row of the CSV
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                // get the semester object from db
                $semester = Semester::where('semester_number', $row[2])
                            ->where('start_year', $row[3])
                            ->where('end_year', $row[4])
                            ->first();

                // get the company object from db
                $company = Company::where("name", $row[5])->first();

                // create the student object and store it at db
                Student::create([
                    'student_id' => $row[0],
                    'name' => $row[1],
                    'company_id' => $company->id,
                    'semester_id' => $semester->id,
                ]);
            }
            fclose($handle);
        }
    }
}
