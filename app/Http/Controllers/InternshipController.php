<?php

namespace App\Http\Controllers;

use App\DAOs\CompanyDAO;
use App\Models\Semester;

class InternshipController extends Controller
{
    protected $companyDAO;
    public function __construct(CompanyDAO $companyDAO)
    {
        $this->companyDAO = $companyDAO;
    }

    public function index()
    {
        $topHiringCompany = $this->companyDAO->getTopHiringCompanies();
        $semester = Semester::find(0);
        return view("home", [
            "selected_semester" => $semester,
            "top_company" => $topHiringCompany,
        ]);
    }
}
