<?php
namespace App\Http\Controllers;
use App\Models\Team;
class HomeController extends Controller
{
    public function index()
    {
        return view('home.index');
    }
    public function start()
    {
        $this->generateTeams();
        return redirect()->route('teams.index')->with('success', 'Teams generated successfully!');
    }
    private function generateTeams()
    {
        Team::active()->update(['is_deleted' => true]);
        $teams = [
            ['name' => 'Team A', 'power' => rand(0, 5)],
            ['name' => 'Team B', 'power' => rand(0, 5)],
            ['name' => 'Team C', 'power' => rand(0, 5)],
            ['name' => 'Team D', 'power' => rand(0, 5)]
        ];
        Team::insert($teams);
    }
}