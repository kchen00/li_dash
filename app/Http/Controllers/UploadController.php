<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function showUploadForm()
    {
        return view('upload.form');
    }

    /* TODO
        validate csv header 
        preview data before saving
        save data to database
        add upload path to gitignore
        
    */
    public function handleUpload(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        $path = $request->file('csv_file')->getRealPath();
        $rows = array_map('str_getcsv', file($path));

        // Optionally: Use first row as headers
        $header = array_shift($rows);

        // Debug or process content
        foreach ($rows as $row) {
            // Example: dd($row);
            // [0] => Company Name, [1] => Address, etc.
        }

        return back()->with('success', 'CSV file uploaded and read successfully.');
    }
}
