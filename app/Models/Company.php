<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    // specify which attribute can be mass assigned
    protected $fillable = [
        'created_at',
        'updated_at'
    ];


    // one company has many students
    public function students(): HasMany {
        return $this->hasMany(Student::class);
    }
}
