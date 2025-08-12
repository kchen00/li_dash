<?php

namespace App\DAOs;

use App\Models\Company;

class CompanyDAO
{
    public function getAll()
    {
        return Company::all();
    }

    public function findById($id)
    {
        return Company::find($id);
    }

    public function getAllPaginated($search = null, $perPage = 20)
    {
        $query = Company::query();

        if ($search) {
            $query->where('company_name', 'like', '%' . $search . '%');
        }

        return $query->paginate($perPage);
    }

    public function getHiringCountByYear(int $id)
    {
        $company = Company::findOrFail($id);

        $hiringByYear = $company->students()
            ->join('semesters', 'students.semester_id', '=', 'semesters.id')
            ->selectRaw('count(students.id) as students, semesters.start_year as year')
            ->groupBy('semesters.start_year')
            ->get();

        return $hiringByYear;
    }

    public function getHiredStudents(int $id)
    {
        return Company::find($id)->students;
    }
}
