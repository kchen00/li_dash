<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    public static function getAllSemester(Request $request)
    {
        $query = Semester::query();

        if ($search = $request->input('search')) {
            $query->where('semester_number', 'like', "%{$search}%")
                ->orWhere('start_year', 'like', "%{$search}%")
                ->orWhere('end_year', 'like', "%{$search}%");
        }

        $semesters = $query->orderBy('start_year', 'desc')->paginate(10);

        return view('semester.semester-listing', ['semesters' => $semesters]);
    }
}
