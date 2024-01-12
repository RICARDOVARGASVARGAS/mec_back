<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'image', 'company_id',
    ];

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
