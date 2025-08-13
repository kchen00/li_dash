<?php

namespace App\Http\Services;

use App\Http\DAOs\CompanyDAO;
use App\Http\DAOs\InternshipDao;

class InternshipService
{
    protected $internshipDAO;

    public function __construct(InternshipDao $internshipDAO)
    {
        $this->internshipDAO = $internshipDAO;
    }

    /**
     * Get hiring statistics per semester.
     */
    public function getHiringPerSemester()
    {
        return $this->internshipDAO->getTotalInternshipsPerSemester();    
    }
}
