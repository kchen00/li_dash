<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\InternshipController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\SemesterController;
use App\Models\Company;
use App\Models\Semester;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use PhpParser\Node\Expr\Cast\Array_;

Route::get('/',[InternshipController::class, 'index'])->name("home");;

// route to show add new data page
Route::get("/add_data", [FileController::class, "upload"])->name("upload");

// route to upload data to server
Route::post("/add_data", [FileController::class, "uploadPost"])->name("uploadPost");

// route to preview the data on table
Route::get("/preview_data", [FileController::class, "previewData"])->name("previewData");

Route::get("/companies", [CompanyController::class, 'getAllCompanies'])->name('companies');
Route::get("/companies/{id}", [CompanyController::class, 'getCompanyById'])->name('companies.getById');
Route::get("/semesters", [SemesterController::class, 'getAllSemester'])->name('semesters');
