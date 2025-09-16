<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array 
    {
        return [
            'title' => 'sometimes|string|max:40',
            'starts_at' => 'sometimes|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'visibility' => 'sometimes|in:open,closed,hidden',
            'notes' => 'nullable|string',
            'status' => 'sometimes|in:draft,open,finished,cancelled',
            'place_id' => 'sometimes|exists:places,id',
            'variant_id' => 'sometimes|exists:sport_variants,id',
        ];    
    }
}