
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Data Guru</h2>
            <p class="text-muted mb-0">Kelola profil dan akun login guru.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                Kembali ke Dashboard
            </a>
            <a href="{{ route('admin.guru.create') }}" class="btn btn-primary">
                + Tambah Guru
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>No.</th>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Email Login</th>
                        <th>Jenis Kelamin</th>
                        <th>Tanggal Lahir</th>
                        <th>Alamat</th>
                        <th>Jumlah Jadwal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($guru as $item)
                        <tr>
                            <td>{{ $guru->firstItem() + $loop->index }}</td>
                            <td>{{ $item->nip }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->user_email ?? '-' }}</td>
                            <td>{{ $item->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                            <td>{{ $item->tanggal_lahir?->format('d/m/Y') ?? '-' }}</td>
                            <td>{{ $item->alamat ?? '-' }}</td>
                            <td>{{ $item->jumlah_jadwal }}</td>
                            <td class="text-nowrap">
                                <a href="{{ route('admin.guru.edit', $item->id) }}"
                                   class="btn btn-sm btn-warning">Edit</a>

                                <form action="{{ route('admin.guru.destroy', $item->id) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus data guru ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                Belum ada data guru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $guru->links() }}
    </div>
</div>
@endsection
