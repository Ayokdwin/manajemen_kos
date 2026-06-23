<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    public function kontrak(){
        return $this->hasMany(Kontrak::class);
    }
    public function pengaduan(){
        return $this->hasMany(Pengaduan::class);
    }
}
