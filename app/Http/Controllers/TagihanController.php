<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tagihan;

class TagihanController extends Controller
{
    public function index()
    {
        $tagihans = Tagihan::with(['kontrak.user', 'kontrak.kamar'])
            ->when(auth()->user()->role !== 'admin', function ($query) {
                $query->whereHas('kontrak', function ($kontrakQuery) {
                    $kontrakQuery->where('user_id', auth()->id());
                });
            })
            ->latest()
            ->get();

        return view('tagihan.index', compact('tagihans'));
    }
}
