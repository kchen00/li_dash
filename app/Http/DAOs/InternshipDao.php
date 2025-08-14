<?php

namespace App\Http\DAOs;

use Illuminate\Support\Facades\DB;

class InternshipDao
{
    public function getTotalInternshipsPerSemester()
    {
        $internshipsPerSemester = DB::table('students')
            ->join('semesters', 'students.semester_id', '=', 'semesters.id')
            ->select(
                DB::raw("CONCAT(semesters.start_year, ' sem ', semesters.semester_number) as semester_label"),
                DB::raw('count(*) as total_internships')
            )
            ->groupBy('semesters.start_year', 'semesters.semester_number')
            ->orderBy('semesters.start_year')
            ->orderBy('semesters.semester_number')
            ->get()
            ->pluck('total_internships', 'semester_label');

        return $internshipsPerSemester;
    }

    public function getTopHiringCompaniesBySemester($semesterId)
    {
        return DB::table('students')
            ->join('companies', 'students.company_id', '=', 'companies.id')
            ->where('students.semester_id', $semesterId)
            ->select('companies.id', 'companies.company_name', DB::raw('count(*) as students_count'))
            ->groupBy('companies.id', 'companies.company_name')
            ->orderByDesc('students_count')
            ->limit(10)
            ->get();
    }
}
