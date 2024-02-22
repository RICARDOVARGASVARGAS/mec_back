<?php

namespace App\Models;

use App\Traits\QueryTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calculate extends Model
{
    use HasFactory, QueryTrait;

    protected $fillable = [
        'number', 'property_calculate', 'driver_calculate', 'ruc_calculate',
        'dni_calculate', 'phone_calculate', 'cel_property_calculate', 'cel_driver_calculate',
        'address_calculate', 'plate_calculate', 'engine_calculate', 'chassis_calculate',
        'brand_calculate', 'model_calculate', 'year_car_calculate', 'color_calculate',
        'km_calculate', 'observation_calculate', 'company_id'
    ];

    protected $allowFilter = [
        'number', 'property_calculate', 'driver_calculate', 'ruc_calculate',
        'dni_calculate', 'phone_calculate', 'cel_property_calculate', 'cel_driver_calculate',
        'address_calculate', 'plate_calculate', 'engine_calculate', 'chassis_calculate',
        'brand_calculate', 'model_calculate', 'year_car_calculate', 'color_calculate',
        'km_calculate', 'observation_calculate'
    ];
    protected $allowSort = [
        'number', 'property_calculate', 'driver_calculate', 'ruc_calculate',
        'dni_calculate', 'phone_calculate', 'cel_property_calculate', 'cel_driver_calculate',
        'address_calculate', 'plate_calculate', 'engine_calculate', 'chassis_calculate',
        'brand_calculate', 'model_calculate', 'year_car_calculate', 'color_calculate',
        'km_calculate', 'observation_calculate'
    ];
    protected $allowIncluded = ['company'];

    function itemCalculates()
    {
        return $this->hasMany(ItemCalculate::class);
    }

    function company()
    {
        return $this->belongsTo(Company::class);
    }
}
