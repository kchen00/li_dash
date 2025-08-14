<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // read csv files from directory storage\. to seed the database

        // Path to the CSV file
        $filePath = storage_path('data\companies.csv');

        if (($handle = fopen($filePath, 'r')) !== false) {
            // Skip the header row
            fgetcsv($handle);

            // Read each row of the CSV
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                Company::create([
                    'name' => $row[0]
                ]);
            }
            fclose($handle);
        }
    }
}
