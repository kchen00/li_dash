<?php

namespace App\DAOs;

use App\Models\Company;

class CompanyDAO
{
    public function getAll()
    {
        return Company::all();
    }

    public function findById($id)
    {
        return Company::find($id);
    }

    public function getAllPaginated($search = null, $perPage = 20)
    {
        $query = Company::query();

        if ($search) {
            $query->where('company_name', 'like', '%' . $search . '%');
        }

        return $query->paginate($perPage);
    }
}
