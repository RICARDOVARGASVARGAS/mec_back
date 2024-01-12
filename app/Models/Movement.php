<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    use HasFactory;

    protected $fillable = ['amount', 'detail', 'date_movement', 'client_id', 'box_id'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function box()
    {
        return $this->belongsTo(Box::class);
    }
}
