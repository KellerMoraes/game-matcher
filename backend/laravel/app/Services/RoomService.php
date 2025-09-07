<?php
namespace App\Services;

use App\Models\User;
use App\Repositories\RoomRepository;
use Illuminate\Database\Eloquent\Collection;

class RoomService
{
    private RoomRepository $roomRepository;
    
    public function __construct(RoomRepository $roomRepository)
    {
        $this->roomRepository = $roomRepository;
    }

    // public function getAll(): Collection
    // {
    //     return $this->userRepository->findAll();
    // }

    // public function getById(int $id): ?User
    // {
    //     return $this->userRepository->findById($id);
    // }
    // public function create(array $data): User
    // {
    //     return $this->userRepository->create($data);
    // }
    // public function update(array $data,int $id): ?User
    // {
    //     $user = $this->userRepository->findById($id);
    //     if(!$user){
    //         return null;
    //     }
    //     return $this->userRepository->update($user, $data);
    // }
    // public function delete(int $id): bool
    // {
    //     $user = $this->userRepository->findById($id);
    //     if(!$user){
    //         return false;
    //     }
    //     return $this->userRepository->delete($user);
    // }

}