<?php

use App\Http\Controllers\EventsController;
use App\Http\Controllers\EventFilesController;
use App\Http\Controllers\ParticipationsController;
use Illuminate\Http\Request;
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

Route::get('/test1', function () {
    return view('tests.test1');
});

Route::post('/test1', function (Request $request) {
    return dump(strlen($request->fieldTextarea));
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/events',[EventsController::class, 'index'])->name('events.index');
    Route::post('/events',[EventsController::class, 'store'])->name('events.store');
    Route::put('/events/{event}',[EventsController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}',[EventsController::class, 'destroy'])->name('events.destroy');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/participations',[ParticipationsController::class, 'index'])->name('participations.index');
    Route::post('/participations',[ParticipationsController::class, 'store'])->name('participations.store');
    Route::get('/participations/{participation}',[ParticipationsController::class, 'show'])->name('participations.show');
    Route::delete('/participations/{participation}', [ParticipationsController::class, 'destroy'])->name('participations.destroy');
});

Route::group(['middleware' => ['auth']], function () {
    Route::post('/event_files/{event_file}/upload', [EventFilesController::class, 'upload'])->name('event_files.upload');
    Route::post('/event_files/{event_file}/delete', [EventFilesController::class, 'delete'])->name('event_files.delete');
});

require __DIR__.'/auth.php';
