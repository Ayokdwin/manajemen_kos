<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    protected $fillable = [
        'kontrak_id',
        'bulan',
        'tahun',
        'jumlah_tagihan',
        'tanggal_jatuh_tempo',
        'status',
    ];
    public function kontrak(){
        return $this->belongsTo(Kontrak::class);
    }

    public function pembayaran(){
        return $this->hasOne(Pembayaran::class);
    }
}
