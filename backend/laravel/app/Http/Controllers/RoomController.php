<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoomRequest;
use App\Services\RoomService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    private RoomService $roomService;

    public function __construct(RoomService $roomService)
    {
        $this->roomService = $roomService;
    }

    public function index(): JsonResponse
    {
          return response()->json($this->roomService->getAll());
    }

    public function show(int $roomId): JsonResponse
    {
       $room = response()->json($this->roomService->getById($roomId));
        if (!$room) {
            return response()->json(['error' => 'Room not found'], 404);
        }

        return response()->json($room);
    }

    public function store(StoreRoomRequest $request): JsonResponse
    {

        $room = $this->roomService->create($request->validated());
        return response()->json($room, 201);
    }

    public function update(StoreRoomRequest $request, int $id): JsonResponse
    {
          $room = $this->roomService->update($request->validated(),$id);

        if (!$room) {
            return response()->json(['error' => 'Room not found'], 404);
        }

        return response()->json($room);
    }

    public function destroy(int $id): JsonResponse
    {
          $deleted = $this->roomService->delete($id);

        if (!$deleted) {
            return response()->json(['error' => 'Room not found'], 404);
        }

        return response()->json(['message' => 'Room Deleted Successfully! ']);
    }

    public function join(int $roomId): JsonResponse
    {
          return response()->json($this->roomService->joinRoom($roomId));
    }

    public function leave(int $roomId): JsonResponse
    {
          return response()->json($this->roomService->leaveRoom($roomId));
    }

    public function approveParticipant(int $roomId, int $userId): JsonResponse
    {
          return response()->json($this->roomService->acceptParticipant($roomId, $userId));
    }

    public function promoteToAdmin(int $roomId, int $userId): JsonResponse
    {
          return response()->json($this->roomService->makeAdmin($roomId, $userId));
    }

    public function setRole(int $roomId, int $userId, string $role): JsonResponse
    {
          return response()->json($this->roomService->setRole($roomId, $userId, $role));
    }
    //
}
