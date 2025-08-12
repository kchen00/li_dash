<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\SemesterController;
use App\Models\Company;
use App\Models\Semester;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use PhpParser\Node\Expr\Cast\Array_;

Route::get('/', function () {
    return redirect()->route('students_per_semester_per_company', ['company_id' => 3, 'semester_id' => 0]);
})->name("home");;

// company page
// show number of students per semester according to the company
Route::get("/company_id={company_id}/semester_id={semester_id?}", function (int $company_id, int $semester_id = 0) {
    // get the selected company
    $company = Company::find($company_id);
    $semester = null;
    // get the selected semester if the id is specified
    if ($semester_id != 0) {
        $semester = Semester::find($semester_id);
    }

    // get all the top ranking company
    $top_company = CompanyController::get_top_company($semester_id);

    // main data to display
    $data = CompanyController::get_student_per_semester($company_id);

    // return the view of the dashboard
    return view("home", [
        "selected_company" => $company,
        "selected_semester" => $semester,
        "companies" => CompanyController::get_all_companies(),
        "semesters" => SemesterController::get_all_semester(),
        "students" => $company->students,
        "data" => $data,
        "top_company" => $top_company,
    ]);
})->name("students_per_semester_per_company");

// route to show add new data page
Route::get("/add_data", [FileController::class, "upload"])->name("upload");

// route to upload data to server
Route::post("/add_data", [FileController::class, "uploadPost"])->name("uploadPost");

// route to preview the data on table
Route::get("/preview_data", [FileController::class, "previewData"])->name("previewData");

Route::get("/companies", [CompanyController::class, 'get_all_companies'])->name('companies');
