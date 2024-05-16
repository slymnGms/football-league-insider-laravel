<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fixture extends Model
{
    use HasFactory;
    protected $fillable = ['home_team_id', 'away_team_id', 'week', 'is_deleted'];
    public function scopeActive($query)
    {
        return $query->where('is_deleted', false);
    }
    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }
    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }
    public function playMatch()
    {
        $standingTeam1 = Standings::where('team_id', $this->home_team_id)->active()->firstOrFail();
        $standingTeam2 = Standings::where('team_id', $this->away_team_id)->active()->firstOrFail();

        $predictionTeam1 = $standingTeam1->points + $standingTeam1->power;
        $predictionTeam2 = $standingTeam2->points + $standingTeam2->power;

        $randomOutcome = rand(0, $predictionTeam1 + $predictionTeam2);
        if ($randomOutcome <= $predictionTeam1) {
            // Team 1 wins
            $defeatGoal = rand(0, $predictionTeam2);
            $goalsA = rand($defeatGoal, $predictionTeam1);
            $this->updateStandings($this->homeTeam, 3, $goalsA, $defeatGoal);
            $this->updateStandings($this->awayTeam, 0, $defeatGoal, $goalsA);
        } elseif ($randomOutcome <= $predictionTeam1 + $predictionTeam2) {
            // Team 2 wins
            $defeatGoal = rand(0, $predictionTeam1);
            $goalsA = rand($defeatGoal, $predictionTeam2);
            $this->updateStandings($this->awayTeam(), 3, $goalsA, $defeatGoal);
            $this->updateStandings($this->homeTeam(), 0, $defeatGoal, $goalsA);
        } else {
            // Draw
            $drawGoal = rand(0, min($predictionTeam1, $predictionTeam2));
            $this->updateStandings($this->homeTeam(), 1, $drawGoal, $drawGoal);
            $this->updateStandings($this->awayTeam(), 1, $drawGoal, $drawGoal);
        }
        $this->update(['is_played' => true]);
    }

    private function updateStandings($team, int $point, int $goalsS, int $goalsA): void
    {
        $standings = Standings::where('team_id', $team->id)->firstOrFail();
        $standings->points += $point;
        $standings->played += 1;
        $standings->goals_for += $goalsS;
        $standings->goals_against += $goalsA;
        if ($point == 0)
            $standings->lost += 1;
        if ($point == 1)
            $standings->drawn += 1;
        if ($point == 3)
            $standings->won += 1;
        $standings->save();
    }

}
