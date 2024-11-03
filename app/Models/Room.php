<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use SoftDeletes;

    public function hotel(){
        // Quarto pertence a um Hotel
        return $this->belongsTo(Hotel::class);
    }

    protected $fillable = [
            'name'
    ];
}
