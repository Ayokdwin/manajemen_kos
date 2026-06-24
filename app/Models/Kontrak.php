<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kontrak extends Model
{
    protected $fillable = [
        'user_id', 'kamar_id', 'tgl_masuk',
        'tgl_selesai', 'deposit', 'status'
    ];
    
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function kamar(){
        return $this->belongsTo(Kamar::class);
    }
    public function tagihan(){
        return $this->hasMany(Tagihan::class);
    }
}
