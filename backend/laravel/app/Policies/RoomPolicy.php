<?php

namespace App\Policies;

use App\Models\Room;
use App\Models\User;

class RoomPolicy
{
    public function update(User $user, Room $room): bool
    {
        // remove adiciona muda de time os jogadores se for admin
        return $user->id === $room->creator_id || $room->participants()->wherePivot('permission', 'admin')->where('users.id', $user->id)->exists();
    }   
    public function delete(User $user, Room $room): bool
    {
        // só deleta a sala se for criador
        return $user->id === $room->creator_id;
    }
    public function acceptParticipant(User $user, Room $room): bool
    {
        return $user->id === $room->creator_id || $room->participants()->wherePivot('permission', 'admin')->where('users.id', $user->id)->exists();
    }

}