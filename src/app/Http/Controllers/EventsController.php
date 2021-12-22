<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $events = Event::all();

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
        $event = new Event;
        $event->user_id = Auth::id();
        $event->title = $request->title;
        $event->description = $request->description;
        $event->place = $request->place;
        $event->fee = $request->fee;
        $event->published = $request->published;
        $event->save();

        $user = User::find(Auth::id());
        $events = Event::all();

        return view('events.index', [
            'user' => $user,
            'events' => $events
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        return view('events.show', ['event' => $event]);
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
        $event->title = $request->title;
        $event->description = $request->description;
        $event->place = $request->place;
        $event->fee = $request->fee;
        $event->published = $request->published;
        $event->save();

        $user = User::find(Auth::id());
        $events = Event::all();

        return view('events.index', [
            'user' => $user,
            'events' => $events
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $event->delete();
    }
}
