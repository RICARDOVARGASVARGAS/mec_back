<?php

namespace App\Models;

use App\Traits\QueryTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory, QueryTrait;

    protected $fillable = [
        'number',  'name', 'hex', 'company_id',
    ];

    protected $allowFilter = ['name', 'hex'];
    protected $allowSort = ['name', 'hex'];
    protected $allowIncluded = ['company'];

    function company()
    {
        return $this->belongsTo(Company::class);
    }

    function cars()
    {
        return $this->hasMany(Car::class);
    }
}
