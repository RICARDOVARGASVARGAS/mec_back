<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Example extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'company_id',
    ];

    function company()
    {
        return $this->belongsTo(Company::class);
    }

    function cars()
    {
        return $this->hasMany(Car::class);
    }
}
