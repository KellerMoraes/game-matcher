<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $table = 'places';

    protected $fillable = 
    [
        'name',
        'city',
        'address',
    ];
    public function rooms(){
        return $this->hasMany(Room::class);
    }
    //
}
