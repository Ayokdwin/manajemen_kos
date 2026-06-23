<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengaduan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kamar_id',
        'judul',
        'diskripsi',
        'status',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function kamar(){
        return $this->belongsTo(Kamar::class);
    }
}
