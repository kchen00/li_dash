<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use App\Http\Services\CompanyService;

class InternshipController extends Controller
{
    protected $companyService;
    public function __construct(CompAnyService $companyService)
    {
        $this->companyService = $companyService;
    }

    public function index()
    {
        $topHiringCompany = $this->companyService->getTopHiringCompanies();
        $semester = Semester::find(0);
        return view("home", [
            "selected_semester" => $semester,
            "top_company" => $topHiringCompany,
        ]);
    }
}
