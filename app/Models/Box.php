<?php

namespace App\Models;

use App\Traits\QueryTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    use HasFactory, QueryTrait;

    protected $fillable = [
        'name', 'image', 'company_id',
    ];

    protected $allowFilter = ['name'];
    protected $allowSort = ['name'];
    protected $allowIncluded = ['company','movements','movements.client'];

    function company()
    {
        return $this->belongsTo(Company::class);
    }

    function payments()
    {
        return $this->hasMany(Payment::class);
    }

    function movements()
    {
        return $this->hasMany(Movement::class);
    }
}
