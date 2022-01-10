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
}
