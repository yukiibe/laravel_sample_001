<?php

namespace App\Policies;

use App\Models\Participation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ParticipationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Participation  $participation
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Participation $participation)
    {
        return $user->id == $participation->user_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->role == 'participant';
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Participation  $participation
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Participation $participation)
    {
        return $user->role == 'participant' && $user->id == $participation->user_id;
    }
}
