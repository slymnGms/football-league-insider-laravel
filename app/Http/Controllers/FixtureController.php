<?php
namespace App\Http\Controllers;

use App\Models\Fixture;
use App\Models\Standings;
use App\Models\Team;

class FixtureController extends Controller
{
    public function index()
    {
        $fixtures = Fixture::active()->get();
        return view('fixtures.index', compact('fixtures'));
    }
    public function start()
    {
        $this->generateStandings();
        return redirect()->route('simulate.index');
    }
    private function generateStandings()
    {
        Standings::active()->update(['is_deleted' => true]);
        $teams = Team::active()->get();
        foreach ($teams as $team) {
            Standings::create([
                'team_id' => $team->id,
                'points' => 0,
                'played' => 0,
                'won' => 0,
                'drawn' => 0,
                'lost' => 0,
                'goals_for' => 0,
                'goals_against' => 0,
            ]);
        }
    }
}