<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCalculate extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'price', 'calculate_id'];

    public function Calculate()
    {
        return $this->belongsTo(Calculate::class);
    }
}
