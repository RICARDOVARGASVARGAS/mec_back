<?php

namespace App\Models;

use App\Traits\QueryTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Example extends Model
{
    use HasFactory, QueryTrait;

    protected $fillable = [
        'number', 'name', 'company_id',
    ];

    protected $allowFilter = ['name'];
    protected $allowSort = ['name'];
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
