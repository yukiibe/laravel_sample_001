<?php

namespace App\Mail;

use App\Models\Participation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ParticipationCompleted extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The participation instance.
     *
     * @var \App\Models\Participation
     */
    protected $participation;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\Participation  $participation
     * @return void
     */
    public function __construct(Participation $participation)
    {
        $this->participation = $participation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.participations.completed')
                    ->with([
                        'participation' => $this->participation,
                        'event' => $this->participation->event,
                    ]);
    }
}
