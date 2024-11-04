<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Semester extends Model
{
    // specify which attribute can be mass assigned
    protected $fillable = [
        'semester_number',
        'start_year',
        'end_year',
        'created_at',
        'updated_at'
    ];


    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }
}
