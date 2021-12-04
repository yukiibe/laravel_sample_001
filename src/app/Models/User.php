<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const ROLE_PARTICIPANT = 'participant';
    const ROLE_ORGANIZER = 'organizer';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the participations for the organizing user
     * 
     * @return \App\Models\Participation  $participation
     */
    public function participationsForOrganizer()
    {
        return $this->hasMany(Participation::class, 'organizer_id');
    }

    /**
     * Get the participations for the participating user
     * 
     * @return \App\Models\Participation  $participation
     */
    public function participationsForParticipant()
    {
        return $this->hasMany(Participation::class, 'participant_id');
    }

    /**
     * Get the events for the user
     * 
     * @return \App\Models\Event  $event
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
