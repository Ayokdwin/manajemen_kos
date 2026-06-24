<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kamar;

class WelcomeController extends Controller
{
    public function index()
    {
        $kamars = Kamar::query()
            ->where('status', 'tersedia')
            ->latest()
            ->take(6)
            ->get();

        return view('welcome', compact('kamars'));
    }
}
