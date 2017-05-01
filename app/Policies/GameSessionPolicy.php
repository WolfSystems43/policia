<?php

namespace App\Policies;

use App\User;
use App\GameSession;
use Illuminate\Auth\Access\HandlesAuthorization;

class GameSessionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the gameSession.
     *
     * @param  \App\User  $user
     * @param  \App\GameSession  $gameSession
     * @return mixed
     */
    public function view(User $user, GameSession $gameSession)
    {
        //
    }

    /**
     * Determine whether the user can create gameSessions.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the gameSession.
     *
     * @param  \App\User  $user
     * @param  \App\GameSession  $gameSession
     * @return mixed
     */
    public function update(User $user, GameSession $gameSession)
    {
        //
    }

    /**
     * Determine whether the user can delete the gameSession.
     *
     * @param  \App\User  $user
     * @param  \App\GameSession  $gameSession
     * @return mixed
     */
    public function delete(User $user, GameSession $gameSession)
    {
        //
    }

    public function startWork(User $user, GameSession $gameSession)
    {

        if($gameSession->start_at->isFuture()) {
            return false;
        }

        if($gameSession->works()->where('user_id', $user->id)->count() > 0) {
            return false;
        }

        return true;
    }
}
