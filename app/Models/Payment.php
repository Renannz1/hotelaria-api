<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public function payment(){
        $this->belongsTo(Reserve::class);
    }

    public $fillable = [
        'value',
        'method',
        'reserve_id'
    ];
}
