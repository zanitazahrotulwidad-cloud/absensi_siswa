<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Jadwal;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'jadwal_id' => ['nullable', 'integer'],
            'tanggal' => ['nullable', 'date'],
            'status' => ['nullable', 'string'],
        ]);

        $absensis = Absensi::query()
            ->lengkap()
            ->when($request->jadwal_id, fn ($query, $id) =>
                $query->where('absensi.jadwal_id', $id))
            ->when($request->tanggal, fn ($query, $tanggal) =>
                $query->whereDate('absensi.tanggal', $tanggal))
            ->when($request->status, fn ($query, $status) =>
                $query->where('absensi.status', $status))
            ->orderByDesc('absensi.tanggal')
            ->orderByDesc('absensi.id')
            ->paginate(20)
            ->withQueryString();

        $jadwalList = $this->jadwalList();

        return view('admin.absensi.index', compact(
            'absensis',
            'jadwalList'
        ));
    }

    public function create(Request $request)
    {
        $request->validate([
            'jadwal_id' => ['nullable', 'integer'],
            'tanggal' => ['nullable', 'date'],
        ]);

        $tanggal = $request->tanggal ?? now()->toDateString();

        $selectedJadwal = null;
        $siswas = collect();
        $absensiAda = collect();

        if ($request->filled('jadwal_id')) {
            $selectedJadwal = Jadwal::query()
                ->lengkap()
                ->where('jadwal.id', $request->jadwal_id)
                ->firstOrFail();

            $siswas = Siswa::where('kelas', $selectedJadwal->kelas)
                ->orderBy('nama')
                ->get();

            $absensiAda = Absensi::where('jadwal_id', $selectedJadwal->id)
                ->whereDate('tanggal', $tanggal)
                ->get()
                ->keyBy('siswa_id');
        }

        $jadwals = $this->jadwalList();

        return view('admin.absensi.create', compact(
            'jadwals',
            'selectedJadwal',
            'siswas',
            'absensiAda',
            'tanggal'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jadwal_id' => ['required', 'exists:jadwal,id'],
            'tanggal' => ['required', 'date'],
            'status' => ['required', 'array', 'min:1'],
            'status.*' => [
                'required',
                Rule::in(array_keys(Absensi::STATUS)),
            ],
            'keterangan' => ['nullable', 'array'],
            'keterangan.*' => ['nullable', 'string', 'max:255'],
        ]);

        $jadwal = Jadwal::findOrFail($validated['jadwal_id']);

        $siswaIds = array_keys($validated['status']);

        $siswas = Siswa::where('kelas', $jadwal->kelas)
            ->whereIn('id', $siswaIds)
            ->get()
            ->keyBy('id');

        foreach ($validated['status'] as $siswaId => $status) {
            if (!$siswas->has($siswaId)) {
                continue;
            }

            Absensi::updateOrCreate(
                [
                    'jadwal_id' => $jadwal->id,
                    'siswa_id' => $siswaId,
                    'tanggal' => $validated['tanggal'],
                ],
                [
                    'status' => $status,
                    'keterangan' => $validated['keterangan'][$siswaId] ?? null,
                ]
            );
        }

        return redirect()
            ->route('admin.absensi.index', [
                'jadwal_id' => $jadwal->id,
                'tanggal' => $validated['tanggal'],
            ])
            ->with('success', 'Data absensi berhasil disimpan.');
    }

    public function edit(Absensi $absensi)
    {
        $absensi = Absensi::query()
            ->lengkap()
            ->where('absensi.id', $absensi->id)
            ->firstOrFail();

        return view('admin.absensi.edit', compact('absensi'));
    }

    public function update(Request $request, Absensi $absensi)
    {
        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in(array_keys(Absensi::STATUS)),
            ],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ]);

        $absensi->update($validated);

        return redirect()
            ->route('admin.absensi.index', [
                'jadwal_id' => $absensi->jadwal_id,
                'tanggal' => $absensi->tanggal->toDateString(),
            ])
            ->with('success', 'Data absensi berhasil diperbarui.');
    }

    public function destroy(Absensi $absensi)
    {
        $jadwalId = $absensi->jadwal_id;
        $tanggal = $absensi->tanggal->toDateString();

        $absensi->delete();

        return redirect()
            ->route('admin.absensi.index', [
                'jadwal_id' => $jadwalId,
                'tanggal' => $tanggal,
            ])
            ->with('success', 'Data absensi berhasil dihapus.');
    }

    private function jadwalList()
    {
        return Jadwal::query()
            ->lengkap()
            ->orderBy('jadwal.kelas')
            ->urut()
            ->get();
    }
}
