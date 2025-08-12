<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Semester;
use App\Models\Student;
use Database\Seeders\StudentSeeder;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\DAOs\CompanyDAO;

class CompanyController extends Controller
{
    protected $companyDAO;
    public function __construct(CompanyDAO $companyDAO)
    {
        $this->companyDAO = $companyDAO;
    }

    // return all the companies
    public function getAllCompanies(Request $request)
    {
        $search = $request->input('search');
        $companies = $this->companyDAO->getAllPaginated($search, 20);

        // Append search query to pagination links
        $companies->appends(['search' => $search]);

        return view('company.company-listing', compact('companies'));
    }

    public function getCompanyById(int $companyId)
    {
        $company = Company::find($companyId);
        return view('company.company', [
            "company" => $company,
            "hiredStudents" => $this->companyDAO->getHiredStudents($companyId),
            "hiringByYear" => $this->companyDAO->getHiringCountByYear($companyId)
        ]);
    }

    // get the companies with top hiring
    // default get the top 10 for all semester
    // specify the semester id to get specific semester
    public function get_top_company(int $semester_id, int $amount = 10)
    {
        $top_company = Company::withCount("students")->orderBy("students_count", "desc")->limit($amount)->get();
        if ($semester_id != 0) {
            $top_company = Company::withCount([
                'students' => function ($query) use ($semester_id) {
                    $query->where('semester_id', $semester_id);  // Filter students by semester_id
                }
            ])
                ->orderBy('students_count', 'desc')  // Order by the filtered students count
                ->limit($amount)
                ->get();
        }

        return $top_company;
    }

    // shows the students per semester under the company with matching company_id
    public function get_student_per_semester(int $company_id = 1)
    {
        // find the company by company_id
        $company = Company::find($company_id);

        // then find the students
        // group by the semester
        $data = $company->students()->with("semester")->get()->groupBy("semester.id");

        // generate semester name for each arry for graph label
        foreach ($data as $semester_id => $students) {
            $semester = Semester::find($semester_id);
            $semester_name = "SEM $semester->semester_number $semester->start_year/$semester->end_year";
            $data[$semester_id]["semester_name"] = $semester_name;
        }

        return $data;
    }
}
