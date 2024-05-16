<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\Fixture;
use App\Models\Team;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::active()->get();
        return view('teams.index', compact('teams'));
    }
    public function start()
    {
        $teams = $this->generateFixtures();
        return redirect()->route('fixtures.index')->with('success', 'Fixtures generated successfully!');
    }
    private function generateFixtures()
    {
        // Log::info('This is some useful information.');
        Fixture::active()->update(['is_deleted' => true]);
        $teams = Team::active()->get()->shuffle();
        $totalTeams = count($teams);
        $totalWeeks = $totalTeams * 2;
        $matchesPerWeek = ceil($totalTeams / 2);
        for ($week = 1; $week <= $totalWeeks; $week++) {
            $weekyTeams = $teams->shuffle()->take($matchesPerWeek);
            $weekyTeamsAway = $teams->diff($weekyTeams)->shuffle();
            foreach($weekyTeams as $weekTeam) {
                $teamAway = $weekyTeamsAway->pop();
                Fixture::create([
                    'home_team_id' => $weekTeam->id,
                    'away_team_id' => $teamAway->id,
                    'week' => $week,
                ]);
            }
        }
        return Fixture::active()->get();
    }
}