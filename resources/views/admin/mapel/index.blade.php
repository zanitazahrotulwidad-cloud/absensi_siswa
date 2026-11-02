@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Data Mata Pelajaran</h2>
            <p class="text-muted mb-0">Kelola data mata pelajaran.</p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                Kembali ke Dashboard
            </a>

            <a href="{{ route('admin.mapel.create') }}" class="btn btn-primary">
                + Tambah Mata Pelajaran
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            
                <form action="{{ route('admin.mapel.index') }}" method="GET" class="row g-2 mb-3">
                    <div class="col-md-9">
                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Cari kode atau nama mata pelajaran..."
                            value="{{ $search ?? request('search') }}"
                        >
                    </div>

                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            Cari
                        </button>

                        <a href="{{ route('admin.mapel.index') }}" class="btn btn-secondary">
                            Reset
                        </a>
                    </div>
                </form>

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>No.</th>
                            <th>Kode</th>
                            <th>Nama Mata Pelajaran</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($mapel as $item)
                            <tr>
                                <td>{{ $mapel->firstItem() + $loop->index }}</td>
                                <td>{{ $item->kode }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->created_at?->format('d/m/Y') ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('admin.mapel.edit', $item->id) }}"
                                       class="btn btn-sm btn-warning">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.mapel.destroy', $item->id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus mata pelajaran ini?')">
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
                                <td colspan="5" class="text-center text-muted py-4">
                                    Belum ada data mata pelajaran.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $mapel->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
