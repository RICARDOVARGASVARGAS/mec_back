<?php

namespace App\Models;

use App\Traits\QueryTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory, QueryTrait;

    protected $fillable = [
        'number',
        'km',
        'entry_date',
        'exit_date',
        'payment_date',
        'discount',
        'status',
        'client_id',
        'car_id',
        'company_id',
    ];

    protected $allowFilter = ['km', 'entry_date', 'exit_date'];
    protected $allowSort = ['km', 'entry_date', 'exit_date'];
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

    function payments()
    {
        return $this->hasMany(Payment::class);
    }

    function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot(['id', 'quantity', 'price_buy', 'price_sell', 'date_sale'])
            ->withTimestamps();
    }

    function services()
    {
        return $this->belongsToMany(Service::class)
            ->withPivot(['id', 'price_service', 'date_service'])
            ->withTimestamps();
    }
}
