<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hotel extends Model
{
    // permitindo a utilizacao do softDeletes
    use SoftDeletes;

    public function rooms(){
        return $this->hasMany(Room::class);
    }

    public function reserves(){
        return $this->hasMany(Reserve::class);
    }

    // o campo name pode ser preenchido em massa
    protected $fillable = [
        'name'
    ];
}
