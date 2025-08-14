<?php

namespace App\Http\Services;

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

    /**
     * Retrieves the top hiring companies for a given semester.
     */
    public function getTopHiringCompaniesBySemester($semesterId)
    {
        return $this->internshipDAO->getTopHiringCompaniesBySemester($semesterId);
    }
}
