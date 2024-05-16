<?php
use App\Http\Controllers\FixtureController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SimulateController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::post('/start', [HomeController::class, 'start'])->name('home.start');
Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');
Route::post('/teams/start', [TeamController::class, 'start'])->name('teams.start');
Route::get('/fixtures', [FixtureController::class, 'index'])->name('fixtures.index');
Route::post('/fixtures/start', [FixtureController::class, 'start'])->name('fixtures.start');
Route::get('/simulate', [SimulateController::class, 'index'])->name('simulate.index');
Route::get('/simulateOne', [SimulateController::class, 'simulateOneWeek']);

// Route::get('/simulate/simulate', [SimulateController::class, 'simulate'])->name('simulate.simulate');

// ajax routes
Route::get('/standings', [SimulateController::class,'getStandings']);
Route::get('/current-week-matches', [SimulateController::class,'getCurrentWeekMatches']);
Route::get('/predictions', [SimulateController::class,'getPredictions']);
