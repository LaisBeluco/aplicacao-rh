<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'full_name',
        'user_name',
        'document',
        'date_birth',
        'mother_name',
        'father_name',
        'role'
    ];
}
