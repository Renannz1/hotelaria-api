<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    public function reserves(){
        $this->hasMany(Reserve::class);
    }
}
