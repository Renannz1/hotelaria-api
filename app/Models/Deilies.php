<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deilies extends Model
{
    public function reserve(){
        $this->belongsTo(Reserve::class);
    }

    protected $fillable = [
        'reserve_id',
        'date',
        'value'
    ];
}
