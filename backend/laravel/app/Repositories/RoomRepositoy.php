<?php
namespace App\Repositories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class RoomRepository
{
    public function findAll(): Collection
    {
        return Room::all()->where('visibility','!==','hidden');
    }
 
    public function findById(int $roomId): ?Room
    {
        return Room::find($roomId);
    }

    public function create(array $data): Room
    {
        return room::create($data);
    }

    public function addParticipant(int $roomId, int $userId, array $extra = [])
    {
        return DB::table('room_participants')->insert([
            'room_id'     => $roomId,
            'user_id'     => $userId,
            'permission'  => $extra['permission'] ?? 'player',
            'state'       => $extra['state'] ?? 'pending',
            'role'        => $extra['role'] ?? null,
            'team_code'   => $extra['team_code'] ?? null,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);
    }

    public function update(Room $room, array $data): Room
    {
        $room->update($data);
        return $room;
    }
    public function delete(Room $room): ?bool
    {
        return $room->delete();
    }
}