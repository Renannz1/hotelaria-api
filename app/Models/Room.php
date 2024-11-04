<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use SoftDeletes;

    // quarto pertence a um Hotel
    public function hotel(){
        return $this->belongsTo(Hotel::class);
    }

    // quarto tem varias reservas
    public function reserve(){
        return $this->hasMany(Reserve::class);
    }

    protected $fillable = [
            'name',
            'hotel_id'
    ];
}
