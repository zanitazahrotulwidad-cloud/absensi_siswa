@extends('layouts.app')

@section('title', 'Siswa yang Diajar')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Siswa yang Diajar</h3>

        <a href="{{ route('guru.dashboard') }}" class="btn btn-secondary">
            Kembali
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            {{-- Filter dan Pencarian --}}
            <form action="{{ route('guru.siswa.index') }}" method="GET" class="row g-3 mb-4">

                <div class="col-md-5">
                    <label class="form-label">Cari Siswa</label>
                    <input
                        type="text"
                        name="q"
                        class="form-control"
                        placeholder="Masukkan nama atau NISN"
                        value="{{ request('q') }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Filter Kelas</label>
                    <select name="kelas" class="form-select">
                        <option value="">Semua Kelas</option>

                        @foreach ($kelasList as $kelas)
                            <option value="{{ $kelas }}"
                                {{ request('kelas') == $kelas ? 'selected' : '' }}>
                                {{ $kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary">
                        Cari
                    </button>

                    <a href="{{ route('guru.siswa.index') }}" class="btn btn-secondary">
                        Reset
                    </a>
                </div>

            </form>

            {{-- Tabel Siswa --}}
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>No.</th>
                            <th>NISN</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Jenis Kelamin</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($siswas as $siswa)
                            <tr>
                                <td>{{ $siswas->firstItem() + $loop->index }}</td>
                                <td>{{ $siswa->nisn }}</td>
                                <td>{{ $siswa->nama }}</td>
                                <td>{{ $siswa->kelas }}</td>
                                <td>{{ $siswa->jenisKelaminLabel() }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">
                                    Tidak ada data siswa yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $siswas->links() }}

        </div>
    </div>

</div>
@endsection