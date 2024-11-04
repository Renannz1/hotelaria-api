<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserve extends Model
{
    public function hotel(){
        return $this->belongsTo(Hotel::class);
    }

    public function room(){
        return $this->belongsTo(Room::class);
    }

    public function deilies(){
        return $this->hasMany(Deilies::class);
    }

    public function guest(){
        return $this->hasOne(Guest::class);
    }

    public function payment(){
        return $this->hasMany(Payment::class);
    }

    protected $fillable = [
        'hotel_id',
        'room_id',
        'total',
        'check_in',
        'check_out'
    ];

}
