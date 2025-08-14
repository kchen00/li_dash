<?php

namespace App\Http\DAOs;
use App\Models\Semester;

class SemesterDao {
    public function getAllSemester()
    {
        return Semester::all();
    }

    public function getAllSemestersWithFilter(?string $search = null, int $perPage = 10)
    {
        $query = Semester::query();

        if ($search) {
            $query->where('semester_number', 'like', "%{$search}%")
                ->orWhere('start_year', 'like', "%{$search}%")
                ->orWhere('end_year', 'like', "%{$search}%");
        }

        return $query->orderBy('start_year', 'desc')->paginate($perPage);
    }


    public function findSemesterById(int $id) {
        return Semester::find($id);
    }

    public function createSemester(array $data)
    {
        return Semester::create($data);
    }
}