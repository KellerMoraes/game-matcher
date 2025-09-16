<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
        'id'       => $this->id,
        'title'=> $this->title,
        'starts_at' => $this->starts_at,
        'ends_at' => $this->ends_at,
        'visibility' => $this->visibility,
        'place' => $this->place ? $this->place->name : null,
        'creator' => new UserResource($this->creator),
        'participants' => UserResource::collection($this->participants),
            // Não retorna password
        ];
    }
}
