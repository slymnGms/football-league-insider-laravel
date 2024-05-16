<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'power', 'is_deleted'];

    // Define scope to fetch only active teams
    public function scopeActive($query)
    {
        return $query->where('is_deleted', false);
    }
}
