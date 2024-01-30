<?php

namespace App\Models;

use App\Traits\QueryTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calculate extends Model
{
    use HasFactory, QueryTrait;

    protected $fillable = [
        'number',
        'client_id',
        'car_id',
        'company_id',
    ];

    protected $allowFilter = ['number'];
    protected $allowSort = ['number'];
    protected $allowIncluded = ['client', 'car', 'company', 'car.client'];

    function client()
    {
        return $this->belongsTo(Client::class);
    }

    function car()
    {
        return $this->belongsTo(Car::class);
    }

    function company()
    {
        return $this->belongsTo(Company::class);
    }

    function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot(['id', 'quantity', 'price_sell'])
            ->withTimestamps();
    }

    function services()
    {
        return $this->belongsToMany(Service::class)
            ->withPivot(['id', 'price_service'])
            ->withTimestamps();
    }
}
