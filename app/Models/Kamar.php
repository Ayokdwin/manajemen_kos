<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    protected $fillable = [
        'nomor_kamar', 'tipe', 'harga_per_bulan',
        'fasilitas', 'status', 'deskripsi'
    ];
    
    public function kontrak(){
        return $this->hasMany(Kontrak::class);
    }
    public function pengaduan(){
        return $this->hasMany(Pengaduan::class);
    }
}
