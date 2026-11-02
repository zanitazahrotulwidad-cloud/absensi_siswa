@extends('layouts.app')

@section('title', 'Input Absensi')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Input Absensi Siswa</h3>
        <a href="{{ route('guru.absensi.index') }}" class="btn btn-secondary">
            Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Periksa kembali data yang dimasukkan:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('guru.absensi.create') }}">
                <div class="row align-items-end">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Pilih Jadwal Mengajar</label>
                        <select name="jadwal_id" class="form-select" required>
                            <option value="">-- Pilih Jadwal --</option>
                            @foreach ($jadwals as $jadwal)
                                <option value="{{ $jadwal->id }}"
                                    @selected($jadwalTerpilih?->id == $jadwal->id)>
                                    {{ $jadwal->hari }} |
                                    {{ $jadwal->jam_mulai }}-{{ $jadwal->jam_selesai }} |
                                    {{ $jadwal->mapel_nama }} |
                                    Kelas {{ $jadwal->kelas }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tanggal Absensi</label>
                        <input type="date" name="tanggal" class="form-control"
                            value="{{ $tanggal }}" required>
                    </div>

                    <div class="col-md-2 mb-3">
                        <button type="submit" class="btn btn-primary w-100">
                            Tampilkan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if ($jadwalTerpilih)
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                Daftar Siswa Kelas {{ $jadwalTerpilih->kelas }}
            </div>

            <div class="card-body">
                @if ($siswaList->isEmpty())
                    <div class="alert alert-warning mb-0">
                        Belum ada siswa di kelas ini.
                    </div>
                @else
                    <form method="POST" action="{{ route('guru.absensi.store') }}">
                        @csrf

                        <input type="hidden" name="jadwal_id"
                            value="{{ $jadwalTerpilih->id }}">

                        <input type="hidden" name="tanggal" value="{{ $tanggal }}">

                        <div class="alert alert-info">
                            Tanggal absensi: <strong>{{ $tanggal }}</strong>.
                            Status yang sudah pernah disimpan akan ditampilkan kembali.
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>NISN</th>
                                        <th>Nama Siswa</th>
                                        <th>Status Kehadiran</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($siswaList as $index => $siswa)
                                        @php
                                            $dataLama = $absensiLama->get($siswa->id);
                                            $statusTerpilih = old(
                                                'status.'.$siswa->id,
                                                $dataLama?->status ?? 'hadir'
                                            );
                                            $keteranganTerpilih = old(
                                                'keterangan.'.$siswa->id,
                                                $dataLama?->keterangan ?? ''
                                            );
                                        @endphp

                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $siswa->nisn }}</td>
                                            <td>{{ $siswa->nama }}</td>
                                            <td>
                                                <select name="status[{{ $siswa->id }}]"
                                                    class="form-select" required>
                                                    @foreach (\App\Models\Absensi::STATUS as $key => $label)
                                                        <option value="{{ $key }}"
                                                            @selected($statusTerpilih === $key)>
                                                            {{ $label }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text"
                                                    name="keterangan[{{ $siswa->id }}]"
                                                    class="form-control"
                                                    value="{{ $keteranganTerpilih }}"
                                                    placeholder="Opsional">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <button type="submit" class="btn btn-success">
                            Simpan Absensi
                        </button>
                    </form>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection
