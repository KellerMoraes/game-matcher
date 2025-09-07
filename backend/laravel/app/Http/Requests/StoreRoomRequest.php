<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array 
    {
        return [
            'title' => 'required|string|max:40',
            'starts_at' => 'required|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'visibility' => 'required|in:open,closed,hidden',
            'notes' => 'nullable|string',
            'status' => 'required|in:draft,open,finished,cancelled',
            'place_id' => 'required|exists:place_id',
            'variant_id' => 'required|exists:sport_variants,id',
        ];    
    }
}