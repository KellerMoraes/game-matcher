<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Http\Resources\RoomResource;
use App\Models\Room;
use App\Services\RoomService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function show(int $roomId)
    {
        $room = Room::findOrFail($roomId);
        return new RoomResource($room);
        // $room = $this->roomService->getById($roomId);
        // if (!$room) {
        //     return response()->json(['error' => 'Room not found'], 404);
        // }

        // return response()->json($room);
    }

    public function store(StoreRoomRequest $request): JsonResponse
    {
        $authUserId = Auth::id();
        $data = $request->all();
        $room = $this->roomService->create($data, $authUserId);
        return response()->json($room, 201);
    }

    public function update(UpdateRoomRequest $request, int $id): JsonResponse
    {
        $room = Room::findOrFail($id);
        $this->authorize('update', $room);
        $updatedRoom = $this->roomService->update($request->all(),$id);

        // if (!$room) {
        //     return response()->json(['error' => 'Room not found'], 404);
        // }

        return response()->json($updatedRoom);
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
            $userId = Auth::id();
            $ok = $this->roomService->joinRoom($roomId, $userId);
          
            return $ok
            ? response()->json(['message' => 'Joined successfully'])
            : response()->json(['message' => 'Could not join'], 400);
    }

    public function leave(int $roomId): JsonResponse
    {
            $userId = Auth::id();
            $ok = $this->roomService->leaveRoom($roomId, $userId);
          
            return $ok
            ? response()->json(['message' => 'Left successfully'])
            : response()->json(['message' => 'Could not leave'], 400);     
    }

    public function acceptParticipant(int $roomId, int $targetUserId): JsonResponse
    {
            $authUserId = Auth::id();
            $ok = $this->roomService->acceptParticipant($roomId, $authUserId, $targetUserId);
          
            return $ok
            ? response()->json(['message' => 'Accepted successfully'])
            : response()->json(['message' => 'Not authorized or invalid user'], 403); 
    }

    public function makeAdmin(int $roomId, int $targetUserId): JsonResponse
    {
          $authUserId = Auth::id();
        $ok = $this->roomService->makeAdmin($roomId, $authUserId, $targetUserId);

        return $ok
            ? response()->json(['message' => 'Now admin'])
            : response()->json(['message' => 'Not authorized'], 403);
    }

    public function setRole(int $roomId, int $targetUserId, Request $request): JsonResponse
    {
        $role = $request->input('role');

        $ok = $this->roomService->setRole($roomId, $targetUserId, $role);

        return $ok
            ? response()->json(['message' => 'Role updated'])
            : response()->json(['message' => 'Could not set role'], 400);
    }
    //
}
