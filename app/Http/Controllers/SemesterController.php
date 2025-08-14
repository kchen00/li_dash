<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Illuminate\Http\Request;
use App\Http\Services\CompanyService;
use App\Http\Services\InternshipService;
use App\Http\Services\SemesterService;


class SemesterController extends Controller
{
    protected $companySevice;
    protected $semesterService;
    protected $internshipService;

    public function __construct(CompanyService $companySevice, SemesterService $semesterService, InternshipService $internshipService)
    {
        $this->semesterService = $semesterService;
        $this->companySevice = $companySevice;
        $this->internshipService = $internshipService;
    }

    public function getAllSemester(Request $request)
    {
        $search = $request->input('search');
        $semesters = $this->semesterService->getAllSemestersWithFilter($search, 10);

        return view('semester.semester-listing', ['semesters' => $semesters]);
    }


    public function getSemesterById(int $semesterId)
    {
        $semester = $this->semesterService->getSemesterById($semesterId);

        return view("semester.semester", [
            "semester" => $semester,
            "top_company" => $this->internshipService->getTopHiringCompaniesBySemester($semester->id)
        ]);
    }

    public function createSemesterForm()
    {
        return view('semester.semester-create');
    }

    public function createSemester(Request $request)
    {
        $request->validate([
            'semester_number' => 'required|string|max:255',
            'start_year' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'end_year' => [
                'required',
                'integer',
                'min:2000',
                'max:' . (date('Y') + 1),
                'gt:start_year'
            ],
        ]);

        $data = $request->only(['semester_number', 'start_year', 'end_year']);
        $error = $this->semesterService->createSemester($data);
        
        if ($error) {
            return back()->withErrors($error)->withInput();
        }

        return redirect()->route('semesters.create')
            ->with('success', 'Semester created successfully.');
    }
}
