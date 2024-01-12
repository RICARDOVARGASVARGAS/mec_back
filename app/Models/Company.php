<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',  'image',
    ];

    function products()
    {
        return $this->hasMany(Product::class);
    }

    function services()
    {
        return $this->hasMany(Service::class);
    }

    function users()
    {
        return $this->hasMany(User::class);
    }

    function clients()
    {
        return $this->hasMany(Client::class);
    }

    function sales()
    {
        return $this->hasMany(Sale::class);
    }

    function boxes()
    {
        return $this->hasMany(Box::class);
    }

    function brands()
    {
        return $this->hasMany(Brand::class);
    }

    function examples()
    {
        return $this->hasMany(Example::class);
    }

    function years()
    {
        return $this->hasMany(Year::class);
    }

    function colors()
    {
        return $this->hasMany(Color::class);
    }
}
