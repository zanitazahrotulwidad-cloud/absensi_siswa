<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\View\View;
use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;

class AbsensiController extends Controller
{

    public function index(Request $request): View
    {
        $guru = auth()->user()->profilGuru();

        if (!$guru) {
            abort(403, 'Profil guru tidak ditemukan.');
        }

        $request->validate([
            'jadwal_id' => ['nullable', 'integer'],
            'tanggal' => ['nullable', 'date'],
            'status' => ['nullable', Rule::in(array_keys(Absensi::STATUS))],
        ]);

        $jadwals = Jadwal::query()
            ->lengkap()
            ->where('jadwal.guru_id', $guru->id)
            ->urut()
            ->get();

        $query = Absensi::query()
            ->lengkap()
            ->where('jadwal.guru_id', $guru->id);

        if ($request->filled('jadwal_id')) {
            $query->where('absensi.jadwal_id', $request->integer('jadwal_id'));
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('absensi.tanggal', $request->date('tanggal'));
        }

        if ($request->filled('status')) {
            $query->where('absensi.status', $request->status);
        }

        $absensi = $query
            ->orderByDesc('absensi.tanggal')
            ->paginate(10)
            ->withQueryString();

        return view('guru.absensi.index', compact('absensi', 'jadwals'));
    }

    public function create(Request $request): View
    {
        $guru = $request->user()->profilGuru();

        abort_if($guru === null, 403, 'Profil guru tidak ditemukan.');

        $jadwals = Jadwal::query()
            ->lengkap()
            ->where('jadwal.guru_id', $guru->id)
            ->urut()
            ->get();

        $jadwalTerpilih = null;
        $siswaList = collect();
        $tanggal = $request->input('tanggal', date('Y-m-d'));
        $absensiLama = collect();

        if ($request->filled('jadwal_id')) {
            $jadwalTerpilih = Jadwal::query()
                ->lengkap()
                ->where('jadwal.id', $request->jadwal_id)
                ->where('jadwal.guru_id', $guru->id)
                ->firstOrFail();

            $siswaList = Siswa::where('kelas', $jadwalTerpilih->kelas)
                ->orderBy('nama')
                ->get();

            $absensiLama = Absensi::where('jadwal_id', $jadwalTerpilih->id)
                ->where('tanggal', $tanggal)
                ->whereIn('siswa_id', $siswaList->pluck('id'))
                ->get()
                ->keyBy('siswa_id');
        }

        return view('guru.absensi.create', compact(
            'jadwals',
            'jadwalTerpilih',
            'siswaList',
            'tanggal',
            'absensiLama'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $guru = $request->user()->profilGuru();

        abort_if($guru === null, 403, 'Profil guru tidak ditemukan.');

        $data = $request->validate([
            'jadwal_id' => ['required', 'exists:jadwal,id'],
            'tanggal' => ['required', 'date'],
            'status' => ['required', 'array', 'min:1'],
            'status.*' => ['required', Rule::in(array_keys(Absensi::STATUS))],
            'keterangan' => ['nullable', 'array'],
            'keterangan.*' => ['nullable', 'string', 'max:255'],
        ]);

        $jadwal = Jadwal::where('id', $data['jadwal_id'])
            ->where('guru_id', $guru->id)
            ->firstOrFail();

        $siswaIds = Siswa::where('kelas', $jadwal->kelas)
            ->whereIn('id', array_keys($data['status']))
            ->pluck('id');

        foreach ($siswaIds as $siswaId) {
            Absensi::updateOrCreate(
                [
                    'jadwal_id' => $jadwal->id,
                    'siswa_id' => $siswaId,
                    'tanggal' => $data['tanggal'],
                ],
                [
                    'status' => $data['status'][$siswaId],
                    'keterangan' => $data['keterangan'][$siswaId] ?? null,
                ]
            );
        }

        return redirect()
            ->route('guru.absensi.index', [
                'jadwal_id' => $jadwal->id,
                'tanggal' => $data['tanggal'],
            ])
            ->with('success', 'Absensi berhasil disimpan.');
    }

    public function edit(Request $request, Absensi $absensi): View
    {
        $this->pastikanMilikGuru($request, $absensi);

        $absensi = Absensi::query()
            ->lengkap()
            ->where('absensi.id', $absensi->id)
            ->firstOrFail();

        return view('guru.absensi.edit', compact('absensi'));
    }

    public function update(Request $request, Absensi $absensi): RedirectResponse
    {
        $this->pastikanMilikGuru($request, $absensi);

        $data = $request->validate([
            'status' => ['required', Rule::in(array_keys(Absensi::STATUS))],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ]);

        $absensi->update($data);

        return redirect()
            ->route('guru.absensi.index', [
                'jadwal_id' => $absensi->jadwal_id,
                'tanggal' => $absensi->tanggal->toDateString(),
            ])
            ->with('success', 'Absensi berhasil diperbarui.');
    }

    public function destroy(Request $request, Absensi $absensi): RedirectResponse
    {
        $this->pastikanMilikGuru($request, $absensi);

        $absensi->delete();

        return redirect()
            ->route('guru.absensi.index')
            ->with('success', 'Absensi berhasil dihapus.');
    }

    private function pastikanMilikGuru(Request $request, Absensi $absensi): void
    {
        $guru = $request->user()->profilGuru();

        abort_if($guru === null, 403, 'Profil guru tidak ditemukan.');

        $milikGuru = Jadwal::where('id', $absensi->jadwal_id)
            ->where('guru_id', $guru->id)
            ->exists();

        abort_unless($milikGuru, 403, 'Anda tidak memiliki akses ke absensi ini.');
    }
}