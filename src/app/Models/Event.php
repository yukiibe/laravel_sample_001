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
}
