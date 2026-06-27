<?php

namespace App\Http\Controllers;

// use App\Models\Pembayaran;
use App\Models\Tagihan;
use App\Models\User;
use Illuminate\Http\Request;
// use App\Models\Kontrak;
// use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $user = User::where('role', 'user')
            ->with(['kontrak' => function ($q) {
                $q->where('status', 'aktif')->with('kamar');
            }])
            ->when($request->search, function ($q, $search) {
                $q->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('no_hp', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('user.index', compact('user'));
    }

    public function show(User $user)
    {
        $user->load([
            'kontrak' => function ($q) {
                $q->with('kamar')->latest();
            },
            'pengaduan' => function ($q) {
                $q->with('kamar')->latest();
            }
        ]);

        $kontrakAktif = $user->kontrak->firstWhere('status', 'aktif');

        $tagihan = $kontrakAktif
            ? Tagihan::where('kontrak_id', $kontrakAktif->id)->latest()->get()
            : collect();

        return view('user.show', compact('user', 'kontrakAktif', 'tagihan'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'no_hp'    => 'required|string|max:20',
        ]);

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => bcrypt($validated['password']),
            'no_hp'    => $validated['no_hp'],
            'role'     => 'user',
        ]);

        return redirect()->route('user.index')->with('success', 'Penyewa berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'no_hp' => 'required|string|max:20',
        ]);

        $user->update($validated);

        return redirect()->route('user.index')->with('success', 'Penyewa berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('user.index')->with('success', 'Penyewa berhasil dihapus.');
    }

}
