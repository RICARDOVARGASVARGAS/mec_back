<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'show', 'module_id'
    ];

    function module()
    {
        return $this->belongsTo(Module::class);
    }

    function users()
    {
        return $this->belongsToMany(User::class);
    }
}
