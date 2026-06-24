<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    public function tagihan(){
        return $this->belongsTo(Tagihan::class);
    }
}
