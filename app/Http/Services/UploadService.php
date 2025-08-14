<?php

namespace App\Http\Services;
use Illuminate\Support\MessageBag;

class UploadService
{
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

    public function readCsvFile($rows, $header)
    {
        $data = [];
        foreach ($rows as $row) {
            $data[] = array_combine($header, $row);
        }

        return $data;
    }

    private function createCompanies(array $data)
    {
        // Logic to create companies from the data
    }

    private function createStudents(array $data)
    {
        // Logic to create students from the data
    }
}
