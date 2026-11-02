@extends('layouts.app')

@section('title', 'Data Siswa')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <h1 class="h3 mb-0">Data Siswa</h1>

    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
            Kembali ke Dashboard
        </a>

        <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary">
            Tambah Siswa
        </a>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card shadow-sm">
    <div class="card-body border-bottom">
        <form method="GET" action="{{ route('admin.siswa.index') }}" class="row g-2">
            <div class="col-md-4">
                <input
                    type="text"
                    class="form-control"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Cari nama, NISN, atau kelas..."
                >
            </div>
            <div class="col-md-auto">
                <button class="btn btn-outline-primary" type="submit">Cari</button>
            </div>
            <div class="col-md-auto">
                <a href="{{ route('admin.siswa.index') }}" class="btn btn-outline-secondary">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>NISN</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Jenis Kelamin</th>
                    <th>Email Akun</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($siswa as $item)
                    <tr>
                        <td>{{ $siswa->firstItem() + $loop->index }}</td>
                        <td><code>{{ $item->nisn }}</code></td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->kelas }}</td>
                        <td>{{ $item->jenisKelaminLabel() }}</td>
                        <td>{{ $item->user_email ?? '-' }}</td>
                        <td class="text-end text-nowrap">
                            <a
                                href="{{ route('admin.siswa.edit', $item->id) }}"
                                class="btn btn-sm btn-outline-warning"
                            >Ubah</a>

                            <form
                                method="POST"
                                action="{{ route('admin.siswa.destroy', $item->id) }}"
                                class="d-inline"
                                onsubmit="return confirm('Hapus siswa {{ $item->nama }} beserta akun loginnya?')"
                            >
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            Belum ada data siswa.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-body">
        {{ $siswa->links() }}
    </div>
</div>
@endsection
