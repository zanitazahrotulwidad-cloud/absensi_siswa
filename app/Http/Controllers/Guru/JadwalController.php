<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use Illuminate\View\View;

class JadwalController extends Controller
{
    public function index(): View
    {
        $guru = auth()->user()->profilGuru();

        if (!$guru) {
            abort(403, 'Profil guru tidak ditemukan.');
        }

        $jadwal = Jadwal::query()
            ->lengkap()
            ->where('jadwal.guru_id', $guru->id)
            ->urut()
            ->get();

        return view('guru.jadwal.index', compact('jadwal'));
    }
}
