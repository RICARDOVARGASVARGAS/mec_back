<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCalculate extends Model
{
    use HasFactory;

    protected $fillable = ['amount_item', 'description_item', 'brand_item', 'price_item', 'calculate_id'];

    public function Calculate()
    {
        return $this->belongsTo(Calculate::class);
    }
}
