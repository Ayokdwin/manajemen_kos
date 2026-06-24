<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        $kontrakAktif = $user->kontrak()->with('kamar')->latest()->first();
        $kamar = $kontrakAktif?->kamar;
        $pembayaran = Pembayaran::whereHas('tagihan.kontrak', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();

        return view('user.dashboard', compact('user', 'kontrakAktif', 'kamar','pembayaran'));
    }
}
