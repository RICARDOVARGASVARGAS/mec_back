<?php

namespace App\Models;

use App\Traits\QueryTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, QueryTrait;

    protected $fillable = [
        'number',  'name', 'ticket', 'price_buy', 'price_sell', 'image', 'company_id',
    ];

    protected $allowFilter = ['name', 'ticket', 'price_buy', 'price_sell'];
    protected $allowSort = ['name', 'ticket', 'price_buy', 'price_sell'];
    protected $allowIncluded = ['company'];


    function company()
    {
        return $this->belongsTo(Company::class);
    }

    function sales()
    {
        return $this->belongsToMany(Sale::class)
            ->withPivot(['id', 'quantity', 'price_buy', 'price_sell', 'date_sale'])
            ->withTimestamps();
    }
}
