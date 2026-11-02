<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Jadwal;
use App\Models\Mapel;
use App\Models\Siswa;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $guru = auth()->user()->profilGuru();

        if (!$guru) {
            abort(403, 'Profil guru tidak ditemukan.');
        }

        $hariIni = Jadwal::hariIni();

        $jadwalHariIni = Jadwal::query()
            ->lengkap()
            ->where('jadwal.guru_id', $guru->id)
            ->where('jadwal.hari', $hariIni)
            ->urut()
            ->get();

        // Statistik dashboard guru
        $stats = [
            'mapel' => Mapel::query()
                ->join('jadwal', 'mapel.id', '=', 'jadwal.mapel_id')
                ->where('jadwal.guru_id', $guru->id)
                ->distinct()
                ->count('mapel.id'),

            'jadwal' => Jadwal::where('guru_id', $guru->id)
                ->count(),

            'siswa' => Siswa::whereIn('kelas', $guru->kelasDiampu())
                ->count(),

            'absensi_hari_ini' => Absensi::query()
                ->join('jadwal', 'absensi.jadwal_id', '=', 'jadwal.id')
                ->where('jadwal.guru_id', $guru->id)
                ->whereDate('absensi.tanggal', today())
                ->count(),
        ];

        return view('guru.dashboard', compact(
            'guru',
            'hariIni',
            'jadwalHariIni',
            'stats'
        ));
    }
}
