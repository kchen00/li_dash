<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use App\Http\Services\CompanyService;
use App\Http\Services\InternshipService;

class InternshipController extends Controller
{
    protected $companyService;
    protected $internshipService;
    public function __construct(CompAnyService $companyService, InternshipService $internshipService)
    {
        $this->companyService = $companyService;
        $this->internshipService = $internshipService;
    }

    public function index()
    {
        $topHiringCompany = $this->companyService->getTopHiringCompanies();
        return view("home", [
            "topCompany" => $topHiringCompany,
            "hiringByYear" => $this->internshipService->getHiringPerSemester()
        ]);
    }
}
