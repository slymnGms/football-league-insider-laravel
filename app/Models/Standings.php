<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Standings extends Model
{
    use HasFactory;
    protected $fillable = [
        'team_id',
        'points',
        'played',
        'won',
        'drawn',
        'lost',
        'goals_for',
        'goals_against',
        'is_deleted',
    ];
    public function scopeActive($query)
    {
        return $query->where('is_deleted', false);
    }
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
