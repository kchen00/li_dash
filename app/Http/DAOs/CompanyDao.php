<?php

namespace App\Http\DAOs;

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

    public function getHiringCountByYear(?int $year = null)
    {
        $query = Company::select('companies.id', 'companies.company_name')
            ->join('students', 'students.company_id', '=', 'companies.id')
            ->join('semesters', 'students.semester_id', '=', 'semesters.id')
            ->selectRaw('companies.id, companies.company_name, COUNT(students.id) as students_count')
            ->groupBy('companies.id', 'companies.company_name');

        if ($year) {
            $query->where(function ($q) use ($year) {
                $q->where('semesters.start_year', $year)
                    ->orWhere('semesters.end_year', $year);
            });
        }

        return $query;
    }

    public function getHiredStudents(int $id)
    {
        return Company::find($id)->students;
    }
}
