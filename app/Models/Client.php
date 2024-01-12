<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'document', 'name', 'surname', 'last_name', 'phone',
        'email', 'address', 'image', 'company_id'
    ];

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
}
