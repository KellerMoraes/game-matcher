<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SportVariant extends Model
{
    protected $table = 'sport_variants';

    protected $fillable = 
    [
        'sport_id',
        'code',
        'team_size',
        'outcome_mode',
        'roles_json',
    ];
    public function sports(){
        return $this->belongsTo(Sport::class);
    }
    public function room(){
        return $this->hasMany(Room::class, 'variant_id');
    }
    //
}
