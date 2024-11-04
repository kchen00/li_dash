<?php

use App\Models\Company;
use App\Models\Semester;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('home', ['company_id' => 3]);
});

// homepage
Route::get('/home/company_id={company_id?}', function ($company_id = 3) {
    $companies = Company::all();
    $selected_company = Company::where("id", $company_id)->first();

    $students = Student::where("company_id", $company_id)->get();

    $student_count = Student::where('company_id', $company_id)
                    ->select('semester_id', DB::raw('count(*) as total_students'))
                    ->groupBy('semester_id')
                    ->get();

    return view('home',
                [
                    'companies' => $companies,
                    'selected_company' => $selected_company,
                    'students'=>$students,
                    'student_count'=>$student_count
                ]);
})->name('home');
