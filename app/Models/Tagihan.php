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

    protected function casts(): array
    {
        return [
            'tanggal_jatuh_tempo' => 'date',
        ];
    }

    public function kontrak(){
        return $this->belongsTo(Kontrak::class);
    }

    public function pembayaran(){
        return $this->hasOne(Pembayaran::class);
    }
}
