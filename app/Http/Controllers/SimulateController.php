<?php
namespace App\Http\Controllers;

use App\Models\Fixture;
use App\Models\Standings;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class SimulateController extends Controller
{
    public function index()
    {
        return view('simulate.index');
    }
    public function simulateOneWeek()
    {
        $currentWeek = $this->getCurrentWeek();
        $this->simulateOne($currentWeek);
    }
    public function simulateAll()
    {
        $remainingWeeks = $this->getActiveWeeks();
        foreach ($remainingWeeks as $week) {
            $this->simulateOne($week);
        }
    }
    //Endpoints
    public function getStandings()
    {
        $standings = Standings::active()->orderBy('points', 'desc')->get();
        $teams = Team::active()->get()->pluck('name', 'id');
        $standings->transform(function ($standing) use ($teams) {
            $standing->team_name = $teams[$standing->team_id];
            return $standing;
        });
        return View::make('partials.standings', compact('standings'))->render();
    }

    public function getCurrentWeekMatches()
    {
        $currentWeek = $this->getCurrentWeek();
        $currentWeekMatches = $this->getFixturesofWeek($currentWeek);
        $teams = Team::active()->get()->pluck('name', 'id');
        $currentWeekMatches->transform(function ($standing) use ($teams) {
            $standing->teamA = $teams[$standing->home_team_id];
            $standing->teamB = $teams[$standing->away_team_id];
            return $standing;
        });
        return View::make('partials.current_week_matches', compact('currentWeekMatches'))->render();
    }
    public function getPredictions()
    {
        $standings = Standings::active()->get();
        $teams = Team::active()->get()->pluck('name', 'id');
        $totalPoints = $standings->sum('points');
        $predictions = [];
        foreach ($standings as $standing) {
            $teamName = isset($teams[$standing->team_id]) ? $teams[$standing->team_id]: 'Unknown';
            $probability = 0;
            if ($totalPoints != 0 && $standing->points != 0) {
                $probability = ($standing->points / $totalPoints) * 100;
            }
            $predictions[$teamName] = $probability;
        }
        return View::make('partials.predictions', compact('predictions'))->render();
    }
    // enpoints
    private function simulateOne(int $weekNumber)
    {
        $currentWeekFixtures = $this->getFixturesofWeek($weekNumber);
        foreach ($currentWeekFixtures as $currentFixture) {
            $currentFixture->playMatch();
        }
    }
    private function getCurrentWeek()
    {
        $currentWeek = Fixture::active()->where('is_played', false)
            ->orderBy('week')
            ->value('week');
        if (!$currentWeek) {
            $currentWeek = Fixture::max('week');
        }
        return $currentWeek ? $currentWeek : 1;
    }
    private function getFixturesofWeek(int $currentWeek)
    {
        return Fixture::active()->where('week', $currentWeek)
            ->where('is_played', false)->get();
    }
    private function getActiveWeeks()
    {
        $activeWeeks = Fixture::active()->where('is_played', false)
            ->distinct('week')
            ->orderBy('week')
            ->pluck('week');
        return $activeWeeks;
    }
}