<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\InternshipController;
use App\Http\Controllers\SemesterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;

Route::get('/',[InternshipController::class, 'index'])->name("home");;

Route::get('/upload', [UploadController::class, 'showUploadForm'])->name('upload.form');
Route::post('/upload', [UploadController::class, 'handleUpload'])->name('upload');

Route::get("/companies", [CompanyController::class, 'getAllCompanies'])->name('companies');
Route::get("/companies/{id}", [CompanyController::class, 'getCompanyById'])->name('companies.getById');

Route::get("/semesters", [SemesterController::class, 'getAllSemester'])->name('semesters');
Route::get("/semesters/{id}", [SemesterController::class, 'getSemesterById'])
    ->where('id', '[0-9]+')
    ->name('semesters.getById');
Route::get("/semesters/create", [SemesterController::class, 'createSemesterForm'])->name('semesters.create');
Route::post("/semesters", [SemesterController::class, 'createSemester'])->name('semesters.store');
