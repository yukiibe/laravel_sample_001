<?php

use App\Http\Controllers\EventsController;
use App\Http\Controllers\EventFilesController;
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
    Route::get('/events',[EventsController::class, 'index'])->name('events.index');
    Route::get('/events/create',[EventsController::class, 'create'])->name('events.create');
    Route::post('/events',[EventsController::class, 'store'])->name('events.store');
    Route::get('/events/{event}',[EventsController::class, 'show'])->name('events.show');
    Route::get('/events/{event}/edit',[EventsController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}',[EventsController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}',[EventsController::class, 'destroy'])->name('events.destroy');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/participations',[ParticipationsController::class, 'index'])->name('participations.index');
    Route::post('/participations',[ParticipationsController::class, 'store'])->name('participations.store');
});

Route::group(['middleware' => ['auth']], function () {
    Route::post('/event_files/{event_file}', [EventFilesController::class, 'update'])->name('event_files.update');
});

require __DIR__.'/auth.php';
