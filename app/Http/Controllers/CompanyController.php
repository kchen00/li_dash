<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Semester;
use App\Models\Student;
use Database\Seeders\StudentSeeder;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    // return all the companies
    public static function get_all_companies() {
        $companies = Company::all();
        return $companies;
    }

    // get the companies with top hiring
    // default get the top 10 for all semester
    // specify the semester id to get specific semester
    public static function get_top_company(int $semester_id, int $amount = 10) {
        $top_company = Company::withCount("students")->orderBy("students_count", "desc")->limit($amount)->get();
        if($semester_id != 0) {
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
    public static function get_student_per_semester(int $company_id=1) {
        // find the company by company_id
        $company = Company::find($company_id);
        
        // then find the students
        // group by the semester
        $data = $company->students()->with("semester")->get()->groupBy("semester.id");
        
        // generate semester name for each arry for graph label
        foreach($data as $semester_id => $students) {
            $semester = Semester::find($semester_id);
            $semester_name = "SEM $semester->semester_number $semester->start_year/$semester->end_year";
            $data[$semester_id]["semester_name"] = $semester_name;
        }

        return $data;
    }

    

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        //
    }

    // helper function to read the csv file and upload to database
    public function readCsv() {
        
    }
}
