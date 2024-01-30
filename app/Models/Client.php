<?php

namespace App\Models;

use App\Traits\QueryTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory, QueryTrait;

    protected $fillable = [
        'number', 'document', 'name', 'surname', 'last_name', 'phone',
        'email', 'address', 'image', 'company_id'
    ];

    protected $allowFilter = ['document', 'name', 'surname', 'last_name', 'phone', 'email', 'address'];
    protected $allowSort = ['document', 'name', 'surname', 'last_name', 'phone', 'email', 'address'];
    protected $allowIncluded = ['company'];

    function company()
    {
        return $this->belongsTo(Company::class);
    }

    function cars()
    {
        return $this->hasMany(Car::class);
    }

    function sales()
    {
        return $this->hasMany(Sale::class);
    }

    function movements()
    {
        return $this->hasMany(Movement::class);
    }

    function calculates()
    {
        return $this->hasMany(Calculate::class);
    }
}
