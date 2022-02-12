<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participation extends Model
{
    use HasFactory;

    /**
     * Get the event for the participation
     * 
     * @return \App\Models\Event  $event
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the event for the participation
     * 
     * @return \App\Models\Event  $event
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * If the event is participated by the user
     * 
     * @param int  $user_id
     * @return bool
     */
    public function isParticipatedByUser($user_id)
    {
        if ($this->user_id == $user_id) {
            return true;
        }
        return false;
    }
}
