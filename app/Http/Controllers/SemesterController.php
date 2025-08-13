<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Illuminate\Http\Request;
use App\DAOs\CompanyDAO;

class SemesterController extends Controller
{
    protected $companyDAO;
    public function __construct(CompanyDAO $companyDAO)
    {
        $this->companyDAO = $companyDAO;
    }

    public static function getAllSemester(Request $request)
    {
        $query = Semester::query();

        if ($search = $request->input('search')) {
            $query->where('semester_number', 'like', "%{$search}%")
                ->orWhere('start_year', 'like', "%{$search}%")
                ->orWhere('end_year', 'like', "%{$search}%");
        }

        $semesters = $query->orderBy('start_year', 'desc')->paginate(10);

        return view('semester.semester-listing', ['semesters' => $semesters]);
    }

    public function getSemesterById(int $semesterId)
    {
        $semester = Semester::find($semesterId);

        return view("semester.semester", [
            "semester" => $semester,
            "top_company" => $this->companyDAO->getTopHiringCompanies($semester->start_year)
        ]);
    }
}
