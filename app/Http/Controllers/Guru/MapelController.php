<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MapelController extends Controller
{
    public function index(): View
    {
        $guru = auth()->user()->profilGuru();

        if (!$guru) {
            abort(403, 'Profil guru tidak ditemukan.');
        }

        $mapel = DB::table('jadwal')
            ->join('mapel', 'jadwal.mapel_id', '=', 'mapel.id')
            ->where('jadwal.guru_id', $guru->id)
            ->select(
                'mapel.id',
                'mapel.kode',
                'mapel.nama'
            )
            ->selectRaw('COUNT(DISTINCT jadwal.kelas) AS jumlah_kelas')
            ->groupBy('mapel.id', 'mapel.kode', 'mapel.nama')
            ->orderBy('mapel.nama')
            ->get();

        return view('guru.mapel.index', compact('mapel'));
    }
}
