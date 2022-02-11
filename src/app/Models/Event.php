<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    /**
     * Get the participations for the event
     * 
     * @return \App\Models\Participation  $participation
     */
    public function participations()
    {
        return $this->hasMany(Participation::class);
    }

    /**
     * Get the event file for the event
     * 
     * @return \App\Models\EventFile  $event_file
     */
    public function eventFile()
    {
        return $this->hasOne(EventFile::class);
    }

    /**
     * If the event is participated by the user
     * 
     * @param int  $user_id
     * @return bool
     */
    public function participatedByUser($user_id)
    {
        foreach ($this->participations as $participation) {
            if ($participation->user_id == $user_id) {
                return true;
            }
        }
        return false;
    }
}
