<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    public function kontrak(){
        return $this->belongsTo(Kontrak::class);
    }
}
