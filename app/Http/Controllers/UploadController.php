<?php

namespace App\Http\Controllers;

use App\Http\Services\SemesterService;
use App\Http\Services\UploadService;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    private $uploadService;
    private $semesterService;

    public function __construct(UploadService $uploadService, SemesterService $semesterService)
    {
        $this->uploadService = $uploadService;
        $this->semesterService = $semesterService;
    }   

    public function showUploadForm()
    {
        return view('upload.form', [
            'semesters' => $this->semesterService->getAllSemester()
        ]);
    }

    public function handleUpload(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
            'semester_id' => 'required|exists:semesters,id',
        ]);

        $path = $request->file('csv_file')->getRealPath();
        $rows = array_map('str_getcsv', file($path, FILE_SKIP_EMPTY_LINES));
        $errors = $this->uploadService->handleUpload($rows, $request->input('semester_id'));

        if ($errors) {
            return back()->withErrors($errors)->withInput();
        }

        return back()
            ->with('success', 'CSV file uploaded and read successfully.');
    }
}
