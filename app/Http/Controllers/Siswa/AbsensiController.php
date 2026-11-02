<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AbsensiController extends Controller
{
    public function index(Request $request): View
    {
        $request->validate([
            'status' => [
                'nullable',
                'string',
                Rule::in(array_keys(Absensi::STATUS)),
            ],
        ]);

        $siswa = $request->user()->profilSiswa();

        abort_if(
            $siswa === null,
            403,
            'Akun ini belum terhubung dengan data siswa.'
        );

        $absensis = Absensi::query()
            ->lengkap()
            ->where('absensi.siswa_id', $siswa->id)
            ->when(
                $request->filled('status'),
                fn ($query) => $query->where(
                    'absensi.status',
                    $request->status
                )
            )
            ->orderByDesc('absensi.tanggal')
            ->orderByDesc('absensi.id')
            ->paginate(15)
            ->withQueryString();

        $rekap = $siswa->rekapAbsensi();

        return view(
            'siswa.absensi.index',
            compact('siswa', 'absensis', 'rekap')
        );
    }
}