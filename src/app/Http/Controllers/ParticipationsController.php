<?php

namespace App\Http\Controllers;

use App\Mail\ParticipationCompleted;
use App\Models\Event;
use App\Models\Participation;
use App\Models\User;
use App\Rules\UniqueParticipationToEventByUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ParticipationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(Auth::id());

        $events = '';
        if ($user->role == 'participant') {
            $participations = Participation::with('event')->where('user_id', $user->id)->get();
        } else if ($user->role == 'organizer') {
            $participations = Participation::with(['user', 'event'])->whereHas('Event', function ($query) use ($user) {
                return $query->where('user_id', $user->id);
            })->get();
            $events = Event::with('participations')->where('user_id', $user->id)->get();
        }

        return view('participations.index', [
            'user' => $user,
            'participations' => $participations,
            'events' => $events,
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
        if ($user->cannot('create', Participation::class)) {
            abort(403);
        }

        $request->validate([
            'event_id' => [new UniqueParticipationToEventByUser],
        ]);

        $participation = new Participation;
        $participation->user_id = $user->id;
        $participation->event_id = $request->event_id;
        $participation->save();

        Mail::to($user)->send(new ParticipationCompleted($participation));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Participation  $participation
     * @return \Illuminate\Http\Response
     */
    public function show(Participation $participation)
    {
        $user = User::find(Auth::id());
        if ($user->cannot('view', $participation)) {
            abort(403);
        }

        return view('participations.show', [
            'user' => $user,
            'participation' => $participation,
            'event' => $participation->event,
            'event_file' => $participation->event->eventFile,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Participation  $participation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Participation $participation)
    {
        $user = User::find(Auth::id());
        if ($user->cannot('delete', $participation)) {
            abort(403);
        }

        $participation->delete();
    }
}
