<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrtuController extends Controller
{
    public function index(Request $request): View
    {
        $siswa = null;
        $absensis = null;
        $rekap = null;

        if ($request->filled('nisn')) {
            $request->validate([
                'nisn' => ['required', 'string', 'max:20'],
            ]);

            $nisn = $request->string('nisn')->trim()->toString();

            $siswa = Siswa::where('nisn', $nisn)->first();

            if (!$siswa) {
                session()->flash(
                    'error',
                    'Data siswa dengan NISN tersebut tidak ditemukan.'
                );
            } else {
                $absensis = Absensi::query()
                    ->lengkap()
                    ->where('absensi.siswa_id', $siswa->id)
                    ->orderByDesc('absensi.tanggal')
                    ->orderByDesc('absensi.id')
                    ->paginate(15)
                    ->withQueryString();

                $rekap = $siswa->rekapAbsensi();
            }
        }

        return view(
            'ortu.index',
            compact('siswa', 'absensis', 'rekap')
        );
    }
}