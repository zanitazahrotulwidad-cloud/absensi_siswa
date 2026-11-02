<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SiswaController extends Controller
{
    public function index(Request $request): View
    {
        $siswa = Siswa::query()
            ->leftJoin('user', 'user.id', '=', 'siswa.user_id')
            ->select('siswa.*', 'user.email as user_email')
            ->when($request->filled('q'), function ($query) use ($request) {
                $kataKunci = '%' . $request->input('q') . '%';

                $query->where(function ($query) use ($kataKunci) {
                    $query->where('siswa.nama', 'like', $kataKunci)
                        ->orWhere('siswa.nisn', 'like', $kataKunci)
                        ->orWhere('siswa.kelas', 'like', $kataKunci);
                });
            })
            ->orderBy('siswa.nama')
            ->paginate(10)
            ->withQueryString();

        return view('admin.siswa.index', compact('siswa'));
    }

    public function create(): View
    {
        return view('admin.siswa.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nisn' => ['required', 'digits:10', 'unique:siswa,nisn'],
            'nama' => ['required', 'string', 'max:255'],
            'kelas' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'tanggal_lahir' => ['nullable', 'date'],
            'alamat' => ['nullable', 'string'],
            'email' => ['required', 'email', 'max:255', 'unique:user,email'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['nama'],
                'email' => $data['email'],
                'password' => $data['password'],
                'role' => User::ROLE_SISWA,
            ]);

            Siswa::create([
                'user_id' => $user->id,
                'nisn' => $data['nisn'],
                'nama' => $data['nama'],
                'kelas' => $data['kelas'],
                'jenis_kelamin' => $data['jenis_kelamin'],
                'tanggal_lahir' => $data['tanggal_lahir'] ?? null,
                'alamat' => $data['alamat'] ?? null,
            ]);
        });

        return redirect()
            ->route('admin.siswa.index')
            ->with('success', 'Data siswa dan akun login berhasil ditambahkan.');
    }

    public function edit(Siswa $siswa): View
    {
        $email = User::where('id', $siswa->user_id)->value('email');

        return view('admin.siswa.edit', compact('siswa', 'email'));
    }

    public function update(Request $request, Siswa $siswa): RedirectResponse
    {
        $data = $request->validate([
            'nisn' => [
                'required',
                'digits:10',
                Rule::unique('siswa', 'nisn')->ignore($siswa->id),
            ],
            'nama' => ['required', 'string', 'max:255'],
            'kelas' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'tanggal_lahir' => ['nullable', 'date'],
            'alamat' => ['nullable', 'string'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('user', 'email')->ignore($siswa->user_id),
            ],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        DB::transaction(function () use ($data, $siswa) {
            $siswa->update([
                'nisn' => $data['nisn'],
                'nama' => $data['nama'],
                'kelas' => $data['kelas'],
                'jenis_kelamin' => $data['jenis_kelamin'],
                'tanggal_lahir' => $data['tanggal_lahir'] ?? null,
                'alamat' => $data['alamat'] ?? null,
            ]);

            $user = User::find($siswa->user_id);

            if ($user !== null) {
                $userData = [
                    'name' => $data['nama'],
                    'email' => $data['email'],
                ];

                if (!empty($data['password'])) {
                    $userData['password'] = $data['password'];
                }

                $user->update($userData);
            }
        });

        return redirect()
            ->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Siswa $siswa): RedirectResponse
    {
        if (Absensi::where('siswa_id', $siswa->id)->exists()) {
            return redirect()
                ->route('admin.siswa.index')
                ->with('error', 'Data siswa tidak dapat dihapus karena sudah memiliki riwayat absensi.');
        }

        DB::transaction(function () use ($siswa) {
            $user = User::find($siswa->user_id);

            $siswa->delete();
            $user?->delete();
        });

        return redirect()
            ->route('admin.siswa.index')
            ->with('success', 'Data siswa dan akun loginnya berhasil dihapus.');
    }
}
