<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class GuruController extends Controller
{
    public function index()
    {
        $jumlahJadwal = DB::table('jadwal')
            ->select('guru_id', DB::raw('COUNT(*) as jumlah_jadwal'))
            ->groupBy('guru_id');

        $guru = Guru::query()
            ->leftJoin('user', 'guru.user_id', '=', 'user.id')
            ->leftJoinSub($jumlahJadwal, 'jadwal_count', function ($join) {
                $join->on('guru.id', '=', 'jadwal_count.guru_id');
            })
            ->select(
                'guru.*',
                'user.email as user_email',
                DB::raw('COALESCE(jadwal_count.jumlah_jadwal, 0) as jumlah_jadwal')
            )
            ->orderBy('guru.nama')
            ->paginate(10);

        return view('admin.guru.index', compact('guru'));
    }

    public function create()
    {
        return view('admin.guru.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:user,email'],
            'password' => ['required', 'string', 'min:8'],
            'nip' => ['required', 'string', 'max:20', 'unique:guru,nip'],
            'nama' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'tanggal_lahir' => ['nullable', 'date'],
            'alamat' => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['nama'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'role' => User::ROLE_GURU,
            ]);

            Guru::create([
                'user_id' => $user->id,
                'nip' => $validated['nip'],
                'nama' => $validated['nama'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
                'alamat' => $validated['alamat'] ?? null,
            ]);
        });

        return redirect()
            ->route('admin.guru.index')
            ->with('success', 'Data guru dan akun login berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $guru = Guru::query()
            ->leftJoin('user', 'guru.user_id', '=', 'user.id')
            ->select('guru.*', 'user.email as user_email')
            ->where('guru.id', $id)
            ->firstOrFail();

        return view('admin.guru.edit', compact('guru'));
    }

    public function update(Request $request, string $id)
    {
        $guru = Guru::findOrFail($id);

        $aturanEmail = ['required', 'email', 'max:255'];
        $uniqueEmail = Rule::unique('user', 'email');

        if ($guru->user_id !== null) {
            $uniqueEmail->ignore($guru->user_id);
        }

        $aturanEmail[] = $uniqueEmail;

        $validated = $request->validate([
            'email' => $aturanEmail,
            'password' => [
                $guru->user_id === null ? 'required' : 'nullable',
                'string',
                'min:8',
            ],
            'nip' => [
                'required',
                'string',
                'max:20',
                Rule::unique('guru', 'nip')->ignore($guru->id),
            ],
            'nama' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'tanggal_lahir' => ['nullable', 'date'],
            'alamat' => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($guru, $validated) {
            if ($guru->user_id !== null) {
                $user = User::findOrFail($guru->user_id);

                $userData = [
                    'name' => $validated['nama'],
                    'email' => $validated['email'],
                ];

                if (!empty($validated['password'])) {
                    $userData['password'] = $validated['password'];
                }

                $user->update($userData);
            } else {
                $user = User::create([
                    'name' => $validated['nama'],
                    'email' => $validated['email'],
                    'password' => $validated['password'],
                    'role' => User::ROLE_GURU,
                ]);

                $guru->user_id = $user->id;
            }

            $guru->nip = $validated['nip'];
            $guru->nama = $validated['nama'];
            $guru->jenis_kelamin = $validated['jenis_kelamin'];
            $guru->tanggal_lahir = $validated['tanggal_lahir'] ?? null;
            $guru->alamat = $validated['alamat'] ?? null;
            $guru->save();
        });

        return redirect()
            ->route('admin.guru.index')
            ->with('success', 'Data guru dan akun login berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $guru = Guru::findOrFail($id);

        if ($guru->jadwal()->exists()) {
            return redirect()
                ->route('admin.guru.index')
                ->with('error', 'Data guru tidak dapat dihapus karena masih memiliki jadwal mengajar.');
        }

        DB::transaction(function () use ($guru) {
            $userId = $guru->user_id;

            $guru->delete();

            if ($userId !== null) {
                User::where('id', $userId)
                    ->where('role', User::ROLE_GURU)
                    ->delete();
            }
        });

        return redirect()
            ->route('admin.guru.index')
            ->with('success', 'Data guru dan akun login berhasil dihapus.');
    }
}
