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
}
