<?php
namespace App\Repositories;

use App\Models\RoomParticipant;
use Illuminate\Database\Eloquent\Collection;

class RoomParticipantRepository
{

    public function findByRoomAndUser(int $userId, int $roomId): ?RoomParticipant
    {
       return RoomParticipant::where('room_id', $roomId)->where('user_id',$userId)->first();
    }

    public function findParticipants(int $roomId): ?Collection
    {
       return RoomParticipant::where('room_id', $roomId)->get();
    }

    public function create(array $data): ?RoomParticipant
    {
        return RoomParticipant::create($data);
    }

    public function update(RoomParticipant $participant, array $data): RoomParticipant
    {
        $participant->update($data);
        return $participant;
    }

    public function delete(RoomParticipant $participant): bool
    {
        return $participant->delete();
    }

    public function findOldestParticipant(int $roomId): ?RoomParticipant
    {
       return RoomParticipant::where('room_id', $roomId)
            ->orderBy('created_at', 'asc')
            ->first();
    }

   
}