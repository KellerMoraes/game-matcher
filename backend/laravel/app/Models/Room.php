<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $table = 'rooms';

    protected $fillable = 
    [
        'title',
        'variant_id',
        'place_id',
        'creator_id',
        'starts_at',
        'ends_at',
        'visibility',
        'notes',
        'status',
    ];
    public function creator(){
        return $this->belongsTo(User::class, 'creator_id');
    }
    public function place(){
        return $this->belongsTo(Place::class);
    }
    public function variant(){
        return $this->belongsTo(SportVariant::class);
    }
    public function participants(){
        return $this->belongsToMany(User::class, 'room_participants')->wherePivot(['team_code', 'permission', 'state'])->withTimestamps();
    }
    //
}
