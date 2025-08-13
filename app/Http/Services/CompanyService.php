<?php

namespace App\Http\Services;

use App\Http\DAOs\CompanyDAO;

class CompanyService
{
    protected $companyDAO;

    public function __construct(CompanyDAO $companyDAO)
    {
        $this->companyDAO = $companyDAO;
    }

    /**
     * Get all companies (non-paginated).
     */
    public function getAllCompanies()
    {
        return $this->companyDAO->getAll();
    }

    /**
     * Find a single company by ID.
     */
    public function getCompanyById($id)
    {
        return $this->companyDAO->findById($id);
    }

    /**
     * Get paginated companies with optional search.
     */
    public function getPaginatedCompanies($search = null, $perPage = 20)
    {
        return $this->companyDAO->getAllPaginated($search, $perPage);
    }

    /**
     * Get top hiring companies for a specific year (or all years if year is null).
     */
    public function getTopHiringCompanies(?int $year = null, int $limit = 10)
    {
        return $this->companyDAO
            ->getHiringCountByYear($year)
            ->orderByDesc('students_count')
            ->take($limit)
            ->get();
    }

    /**
     * Get all students hired by a specific company.
     */
    public function getHiredStudentsByCompany(int $companyId)
    {
        return $this->companyDAO->getHiredStudents($companyId);
    }
}
