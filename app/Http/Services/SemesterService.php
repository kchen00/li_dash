<?php

namespace App\Http\Services;

use App\Http\DAOs\SemesterDao;
use App\Models\Semester;
use Illuminate\Support\MessageBag;

class SemesterService
{
    protected $semesterDao;

    public function __construct(SemesterDao $semesterDao)
    {
        $this->semesterDao = $semesterDao;
    }

    public function getAllSemester()
    {
        return $this->semesterDao->getAllSemester();
    }

    public function getAllSemestersWithFilter(?string $search = null, int $perPage = 10)
    {
        return $this->semesterDao->getAllSemestersWithFilter($search, $perPage);
    }

    public function getSemesterById(int $id)
    {
        return $this->semesterDao->findSemesterById($id);
    }

    public function createSemester(array $data): ?MessageBag
    {
        $exists = Semester::where('semester_number', $data['semester_number'])
            ->where('start_year', $data['start_year'])
            ->where('end_year', $data['end_year'])
            ->exists();

        if ($exists) {
            return new MessageBag(['error' => 'Semester already exists with the same number and years.']);
        }

        $semester = $this->semesterDao->createSemester($data);
        return $semester ? null : new MessageBag(['error' => 'Failed to create semester.']);
    }
}