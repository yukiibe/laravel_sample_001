<?php

use App\Http\Controllers\EventsController;
use App\Http\Controllers\ParticipationsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/events/create',[EventsController::class, 'create'])->name('events.create');
    Route::post('/events',[EventsController::class, 'store'])->name('events.store');
    Route::get('/events/{event}',[EventsController::class, 'show'])->name('events.show');
});

Route::group(['middleware' => ['auth']], function () {
    Route::post('/participations',[ParticipationsController::class, 'store'])->name('participations.store');
});

require __DIR__.'/auth.php';
