<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    // specify which attribute can be mass assigned
    protected $fillable = [
        'student_id',
        'name',
        'created_at',
        'updated_at'
    ];

    // reverse relation to company
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    // reverse relation to semester
    public function semester(): BelongsTo
    {
        return $this->belongsTo(semester::class);
    }
}
