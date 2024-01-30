<?php

namespace App\Models;

use App\Traits\QueryTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory, QueryTrait;

    protected $fillable = [
        'number', 'name', 'ticket', 'image', 'company_id'
    ];

    protected $allowFilter = ['name', 'ticket'];
    protected $allowSort = ['name', 'ticket'];
    protected $allowIncluded = ['company'];


    function company()
    {
        return $this->belongsTo(Company::class);
    }

    function sales()
    {
        return $this->belongsToMany(Sale::class)
            ->withPivot(['id', 'price_service', 'date_service'])
            ->withTimestamps();
    }

    function calculates()
    {
        return $this->belongsToMany(Calculate::class)
            ->withPivot(['id', 'price_service'])
            ->withTimestamps();
    }
}
