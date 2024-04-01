<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCalculate extends Model
{
    use HasFactory;

    protected $fillable = ['amount', 'description', 'brand', 'price', 'calculate_id'];

    public function Calculate()
    {
        return $this->belongsTo(Calculate::class);
    }
}
