<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    protected $fillable = ['kontrak_id','bulan','tahun','jumlah_tagihan','tgl_jatuh_tempo','status'];

    public function kontrak(){
        return $this->belongsTo(Kontrak::class);
    }
}
