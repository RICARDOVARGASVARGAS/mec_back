<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'ticket', 'price_buy', 'price_sell', 'image', 'company_id',
    ];

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
