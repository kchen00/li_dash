<?php

namespace App\Http\Services;

use App\Models\Company;
use Illuminate\Support\MessageBag;
use App\Models\Student;

class UploadService
{
    private $companyName = "COMPANY NAME";
    private $studentName = "STUDENT NAME";
    private $studentId = "STUDENT ID";


    public function handleUpload(array $rows): ?MessageBag
    {
        $errors = new MessageBag();

        $header = array_shift($rows);

        if (!$this->validateCsvHeader($header)) {
            $errors->add('error', 'Invalid CSV header. Check the required headers: Student ID, Student Name, Company Name.');
            return $errors; // early return, or continue collecting all errors
        }

        if (!$this->validateCsvRow($rows, $header)) {
            $errors->add('error', 'Invalid CSV data. Ensure all rows match the header');
            return $errors;
        }

        $studentIds = array_column($rows, 'Student ID');
        if (!$this->validateStudentIds($studentIds)) {
            $errors->add('error', 'Duplicate Student IDs found in the CSV.');
            return $errors;
        }

        $data = $this->readCsvFile($rows, $header);
        $this->createCompanies($data);
        $this->createStudents($data, 1);
        return null; // no errors
    }

    /**
     * Validate the CSV header.
     */
    public function validateCsvHeader(array $header)
    {
        $requiredHeaders = ['Student ID', 'Student Name', 'Company Name'];
        return !in_array($requiredHeaders, $header);
    }

    /**
     * Validate the CSV rows against the header.
     */
    public function validateCsvRow(array $rows, array $header)
    {
        foreach ($rows as $row) {
            if (count($row) !== count($header)) {
                return false; // Row does not match header length
            }
        }
        return true;
    }

    /**
     * Validate that all student IDs are unique.
     */
    public function validateStudentIds(array $studentIds)
    {
        return count($studentIds) === count(array_unique($studentIds));
    }

    private function readCsvFile($rows, $header)
    {
        $data = [];
        foreach ($rows as $row) {
            $data[] = array_combine($header, $row);
        }

        return $data;
    }

    private function createCompanies(array $rows)
    {
        $originalNames = collect($rows)
            ->pluck($this->companyName)
            ->filter()
            ->unique()
            ->mapWithKeys(fn($name) => [strtolower(trim($name)) => trim($name)]);

        $existing = Company::pluck('company_name')
            ->map(fn($name) => strtolower(trim($name)))
            ->toArray();

        $newCompanies = collect($originalNames)
            ->except($existing)
            ->values()
            ->map(fn($name) => [
                'company_name' => $name,
                'created_at' => now(),
                'updated_at' => now()
            ]);

        Company::insert($newCompanies->all());
    }


    private function createStudents(array $rows, int $semesterId)
    {
        $existingStudentIds = Student::pluck('student_id')
            ->map(fn($id) => strtolower(trim($id)))
            ->all();

        $companies = Company::pluck('id', 'company_name')
            ->mapWithKeys(fn($id, $name) => [strtolower(trim($name)) => $id])
            ->all();

        $studentsToInsert = collect($rows)
            ->map(function ($row) use ($companies, $existingStudentIds, $semesterId) {
                $studentId = strtolower(trim($row[$this->studentId] ?? ''));
                $studentName = trim($row[$this->studentName] ?? '');
                $companyKey = strtolower(trim($row[$this->companyName] ?? ''));

                // Validation
                if (
                    !$studentId || !$studentName ||
                    !isset($companies[$companyKey]) ||
                    in_array($studentId, $existingStudentIds)
                ) {
                    return null; // Skip this row
                }

                return [
                    'student_id' => $studentId,
                    'name' => $studentName,
                    'company_id' => $companies[$companyKey],
                    'semester_id' => $semesterId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            })
            ->filter() // remove nulls
            ->values()
            ->all();

        if (!empty($studentsToInsert)) {
            Student::insert($studentsToInsert);
        }
    }
}
