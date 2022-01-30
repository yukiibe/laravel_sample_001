<?php

namespace App\Http\Controllers;

use App\Models\EventFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class EventFilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EventFile  $eventFile
     * @return \Illuminate\Http\Response
     */
    public function show(EventFile $eventFile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EventFile  $eventFile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EventFile $eventFile)
    {
        Storage::disk('public')->delete($eventFile->event_id . ".png");

        $path = $request->file('file')->storeAs(
            'events', $eventFile->event_id . ".png", ['disk' => 'public']
        );
        $url = Storage::url($path);

        $eventFile->file = $url;
        $eventFile->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EventFile  $eventFile
     * @return \Illuminate\Http\Response
     */
    public function destroy(EventFile $eventFile)
    {
        //
    }
}
