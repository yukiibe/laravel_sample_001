<?php

namespace App\Http\Controllers;

use App\Models\EventFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class EventFilesController extends Controller
{
    /**
     * Upload the event file in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EventFile  $eventFile
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request, EventFile $eventFile)
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
     * Delete the event file from storage.
     *
     * @param  \App\Models\EventFile  $eventFile
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, EventFile $eventFile)
    {
        Storage::disk('public')->delete($eventFile->event_id . ".png");

        $eventFile->file = '';
        $eventFile->save();
    }
}
