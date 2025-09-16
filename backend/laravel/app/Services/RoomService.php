<?php
namespace App\Services;

use App\Models\Room;
use App\Models\User;
use App\Repositories\RoomParticipantRepository;
use App\Repositories\RoomRepository;
use Illuminate\Database\Eloquent\Collection;

class RoomService
{
    private RoomRepository $roomRepository;
    private RoomParticipantRepository $participantRepository;
    
    public function __construct(RoomRepository $roomRepository, RoomParticipantRepository $participantRepository)
    {
        $this->roomRepository = $roomRepository;
        $this->participantRepository = $participantRepository;
    }

    public function getAll(): Collection
    {
        return $this->roomRepository->findAll();
    }

    public function getById(int $roomId): ?Room
    {
        return $this->roomRepository->findById($roomId);
    }
    public function create(array $data, int $authUserId): Room
    {
        $room = $this->roomRepository->create(array_merge($data, [
        'creator_id' => $authUserId,
    ]));

    // adiciona o criador como dono na participants
    $this->roomRepository->addParticipant($room->id, $authUserId, [
        'permission' => 'owner',
        'state' => 'approved',
    ]);

    return $room;
    }
    public function update(array $data,int $id): ?Room
    {
        $room = $this->roomRepository->findById($id);
        if(!$room){
            return null;
        }
        return $this->roomRepository->update($room, $data);
    }
    public function delete(int $id): bool
    {
        $room = $this->roomRepository->findById($id);
        if(!$room){
            return false;
        }
        return $this->roomRepository->delete($room);
    }



    public function joinRoom(int $roomId, int $userId): bool
    {
        $room = $this->roomRepository->findById($roomId);
        if(!$room){
            return false;
        }
        $alreadyIn = $this->participantRepository->findByRoomAndUser($userId,$roomId);
        
        if($alreadyIn){
            return false; 
        }
        $state = $room->visibility === 'open' ? 'approved' : 'pending';

        $this->participantRepository->create([
            'room_id' => $roomId,
            'user_id' => $userId,
            'state' => $state,
            'permission' => 'player',
        ]);

        return true;
    }

    public function leaveRoom(int $roomId, int $userId): bool
    {
        $room = $this->roomRepository->findById($roomId);
        if(!$room){
            return false;
        }
        $participant = $this->participantRepository->findByRoomAndUser($userId,$roomId);
        
        if(!$participant){
            return false; 
        }
        if($participant->permission === 'owner'){
            $participants = $this->participantRepository->findParticipants($roomId);
            if($participants->count() === 1){
                $this->roomRepository->delete($room);
            }else{
                $newOwner = $this->participantRepository->findOldestParticipant($roomId);
                $this->participantRepository->update($newOwner,['permission' => 'owner']);
            }

        }
        $this->participantRepository->delete($participant);
        return true;

    }
    public function acceptParticipant(int $roomId, int $authUserId, int $targetUserId ): bool
    {
        $auth = $this->participantRepository->findByRoomAndUser($authUserId,$roomId);
        if(!$auth || !in_array($auth->permission, ['owner', 'admin'])){
            return false;
        }
        $target = $this->participantRepository->findByRoomAndUser($targetUserId,$roomId);
        if(!$target || $target->state !== 'pending' ){
            return false;
        }

        $this->participantRepository->update($target, ['state' => 'approved']);
        return true;
    }
    public function makeAdmin(int $roomId, int $authUserId, int $targetUserId): bool
    {
        $auth = $this->participantRepository->findByRoomAndUser($authUserId,$roomId);
        if(!$auth || $auth->permission !== 'owner'){
            return false;
        }
        $target = $this->participantRepository->findByRoomAndUser($targetUserId,$roomId);
        if(!$auth){
            return false;
        }
        $this->participantRepository->update($target, ['permission' => 'admin']);
        return true;
    }
    public function setRole(int $roomId, int $userId, string $role): bool
    {
        $participant = $this->participantRepository->findByRoomAndUser($userId,$roomId);
        if(!$participant){
            return false;
        }
        $this->participantRepository->update($participant, ['role' => $role]);
        return true;
    }

}