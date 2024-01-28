<?php

namespace App\Models;

use App\Traits\QueryTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    use HasFactory, QueryTrait;

    protected $fillable = ['amount', 'detail', 'date_movement', 'client_id', 'box_id'];

    // protected $allowFilter = ['name'];
    // protected $allowSort = ['name'];
    // protected $allowIncluded = ['company'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function box()
    {
        return $this->belongsTo(Box::class);
    }
}
