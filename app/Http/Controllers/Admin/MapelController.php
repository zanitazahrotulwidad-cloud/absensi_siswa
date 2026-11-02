<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Guru;
use App\Models\Siswa;

class MapelController extends Controller
{

public function index(Request $request)
    {
        $search = $request->input('search');

        $mapel = Mapel::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('kode', 'like', '%' . $search . '%')
                    ->orWhere('nama', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        return view('admin.mapel.index', compact('mapel', 'search'));
    }

    public function create()
    {
        return view('admin.mapel.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => ['required', 'string', 'max:20', 'unique:mapel,kode'],
            'nama' => ['required', 'string', 'max:255'],
        ]);

        Mapel::create($validated);

        return redirect()
            ->route('admin.mapel.index')
            ->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $mapel = Mapel::findOrFail($id);

        return view('admin.mapel.edit', compact('mapel'));
    }

    public function update(Request $request, string $id)
    {
        $mapel = Mapel::findOrFail($id);

        $validated = $request->validate([
            'kode' => [
                'required',
                'string',
                'max:20',
                Rule::unique('mapel', 'kode')->ignore($mapel->id),
            ],
            'nama' => ['required', 'string', 'max:255'],
        ]);

        $mapel->update($validated);

        return redirect()
            ->route('admin.mapel.index')
            ->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $mapel = Mapel::findOrFail($id);

        if ($mapel->jadwal()->exists()) {
            return redirect()
                ->route('admin.mapel.index')
                ->with('error', 'Mata pelajaran tidak dapat dihapus karena masih digunakan dalam jadwal.');
        }

        $mapel->delete();

        return redirect()
            ->route('admin.mapel.index')
            ->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}
