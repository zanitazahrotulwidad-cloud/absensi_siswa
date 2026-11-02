<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiswaController extends Controller
{
    public function index(Request $request): View
    {
        $guru = $request->user()->profilGuru();

        abort_if($guru === null, 403, 'Profil guru tidak ditemukan.');

        // Mengambil daftar kelas yang diajar guru
        $kelasList = $guru->kelasDiampu();

        // Mengambil siswa sesuai kelas yang diajar
        $siswas = Siswa::query()
            ->whereIn('kelas', $kelasList)
            ->when($request->filled('kelas'), function ($query) use ($request, $kelasList) {
                if (in_array($request->kelas, $kelasList)) {
                    $query->where('kelas', $request->kelas);
                }
            })
            ->when($request->filled('q'), function ($query) use ($request) {
                $kataKunci = '%' . $request->q . '%';

                $query->where(function ($query) use ($kataKunci) {
                    $query->where('nama', 'like', $kataKunci)
                        ->orWhere('nisn', 'like', $kataKunci);
                });
            })
            ->orderBy('kelas')
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        return view('guru.siswa.index', compact(
            'guru',
            'siswas',
            'kelasList'
        ));
    }
}