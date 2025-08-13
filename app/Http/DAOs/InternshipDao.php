<?php

namespace App\Http\DAOs;

use App\Models\Company;
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
}
