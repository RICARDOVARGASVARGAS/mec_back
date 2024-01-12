<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'ticket', 'image', 'company_id'
    ];

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
}
