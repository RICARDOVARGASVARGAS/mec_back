<?php

namespace App\Models;

use App\Traits\QueryTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory, QueryTrait;

    protected $fillable = [
        'name', 'hex', 'company_id',
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
