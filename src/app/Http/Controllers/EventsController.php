<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventFile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(Auth::id());
        if ($user->role == 'participant') {
            $events = Event::with('eventFile')->get();
        } else if ($user->role == 'organizer') {
            $events = Event::with(['eventFile'])->where('user_id', $user->id)->get();
        }

        return view('events.index', [
            'user' => $user,
            'events' => $events
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::find(Auth::id());
        if ($user->cannot('create', Event::class)) {
            abort(403);
        }

        return view('events.create', [
            'user' => $user
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::find(Auth::id());
        if ($user->cannot('create', Event::class)) {
            abort(403);
        }

        $event = new Event;
        $event->user_id = Auth::id();
        $event->title = $request->title;
        $event->description = $request->description;
        $event->place = $request->place;
        $event->fee = $request->fee;
        $event->published = $request->published;
        $event->save();

        $event_file = new EventFile;
        $event->eventFile()->save($event_file);

#        $events = $user->events;

#        return view('events.index', [
#            'user' => $user,
#            'events' => $events
#        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        $user = User::find(Auth::id());
        if ($user->cannot('view', $event)) {
            abort(403);
        }

        return view('events.show', [
            'user' => $user,
            'event' => $event
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        $user = User::find(Auth::id());
        if ($user->cannot('update', $event)) {
            abort(403);
        }

        return view('events.edit', [
            'user' => $user,
            'event' => $event
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        $user = User::find(Auth::id());
        if ($user->cannot('update', $event)) {
            abort(403);
        }

        $event->title = $request->title;
        $event->description = $request->description;
        $event->place = $request->place;
        $event->fee = $request->fee;
        $event->published = $request->published;
        $event->save();

        $events = $user->events;

#        return view('events.index', [
#            'user' => $user,
#            'events' => $events
#        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $user = User::find(Auth::id());
        if ($user->cannot('delete', $event)) {
            abort(403);
        }

        $event->delete();
    }
}
