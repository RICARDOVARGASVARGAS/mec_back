<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'plate', 'engine', 'chassis', 'image', 'client_id',
        'example_id', 'color_id', 'brand_id', 'year_id'
    ];

    function client()
    {
        return $this->belongsTo(Client::class);
    }

    function example()
    {
        return $this->belongsTo(Example::class);
    }

    function color()
    {
        return $this->belongsTo(Color::class);
    }

    function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    function year()
    {
        return $this->belongsTo(Year::class);
    }

    function sales()
    {
        return $this->hasMany(Sale::class);
    }
}