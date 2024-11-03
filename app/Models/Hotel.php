<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hotel extends Model
{
    // permitindo a utilizacao do softDeletes
    use SoftDeletes;

    // o modelo hotel pode ter varios quartos
    public function rooms(){
        return $this->hasMany(Room::class);
    }

    // o campo name pode ser preenchido em massa
    protected $fillable = [
        'name'
    ];
}
