<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $fillable = [
        'tagihan_id',
        'tgl_bayar',
        'metode',
        'bukti_bayar',
        'status_varifikasi',
    ];

    public function tagihan(){
        return $this->belongsTo(Tagihan::class);
    }
}
