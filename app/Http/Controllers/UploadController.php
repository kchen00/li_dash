<?php

namespace App\Http\Controllers;

use App\Http\Services\UploadService;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    private $uploadService;

    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }   

    public function showUploadForm()
    {
        return view('upload.form');
    }

    /* TODO
        save data to database
        add upload path to gitignore
        create students when csv is uploaded
        create semesters when csv is uploaded
    */
    public function handleUpload(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        $path = $request->file('csv_file')->getRealPath();
        $rows = array_map('str_getcsv', file($path, FILE_SKIP_EMPTY_LINES));
        $errors = $this->uploadService->handleUpload($rows);

        if ($errors) {
            return back()->withErrors($errors)->withInput();
        }

        return back()
            ->with('success', 'CSV file uploaded and read successfully.');
    }
}
