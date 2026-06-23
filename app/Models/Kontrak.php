<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kontrak extends Model
{
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function tagihan(){
        return $this->hasMany(Tagihan::class);
    }
}
