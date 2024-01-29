<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'number', 'detail',
        'amount',
        'date_payment',
        'sale_id',
        'box_id',
    ];

    function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    function box()
    {
        return $this->belongsTo(Box::class);
    }
}
