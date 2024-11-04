<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    public function guest(){
        $this->belongsTo(Reserve::class);
    }

    protected $fillable = [
        'name',
        'last_name',
        'reserve_id',
        'phone'
    ];
}
