
@extends('layouts.app')

@section('title', 'Input Absensi')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Input Absensi Siswa</h3>
            <p class="text-muted mb-0">Catat kehadiran siswa berdasarkan jadwal pelajaran.</p>
        </div>
        <a href="{{ route('admin.absensi.index') }}" class="btn btn-outline-secondary">
            Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.absensi.create') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-7">
                        <label class="form-label">Jadwal Pelajaran</label>
                        <select name="jadwal_id" class="form-select" required>
                            <option value="">-- Pilih Jadwal --</option>
                            @foreach ($jadwals as $jadwal)
                                <option value="{{ $jadwal->id }}"
                                    @selected(request('jadwal_id') == $jadwal->id)>
                                    {{ $jadwal->kelas }} - {{ $jadwal->mapel_nama }}
                                    ({{ $jadwal->hari }},
                                    {{ substr($jadwal->jam_mulai, 0, 5) }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Tanggal Absensi</label>
                        <input type="date" name="tanggal" class="form-control"
                            value="{{ $tanggal }}" required>
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            Tampilkan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if ($selectedJadwal)
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h5 class="fw-bold mb-1">
                            {{ $selectedJadwal->mapel_nama }} - {{ $selectedJadwal->kelas }}
                        </h5>
                        <small class="text-muted">
                            {{ $selectedJadwal->hari }},
                            {{ substr($selectedJadwal->jam_mulai, 0, 5) }} -
                            {{ substr($selectedJadwal->jam_selesai, 0, 5) }}
                            | {{ \Carbon\Carbon::parse($tanggal)->format('d/m/Y') }}
                        </small>
                    </div>
                    <button type="button" id="tandaiSemuaHadir" class="btn btn-sm btn-outline-success">
                        Tandai Semua Hadir
                    </button>
                </div>
            </div>

            <div class="card-body">
                @if ($siswas->isEmpty())
                    <div class="alert alert-warning mb-0">
                        Belum ada siswa di kelas {{ $selectedJadwal->kelas }}.
                    </div>
                @else
                    <form method="POST" action="{{ route('admin.absensi.store') }}">
                        @csrf

                        <input type="hidden" name="jadwal_id" value="{{ $selectedJadwal->id }}">
                        <input type="hidden" name="tanggal" value="{{ $tanggal }}">

                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th width="50">No.</th>
                                        <th>NISN</th>
                                        <th>Nama Siswa</th>
                                        <th width="180">Status Kehadiran</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($siswas as $index => $siswa)
                                        @php
                                            $dataLama = $absensiAda->get($siswa->id);
                                        @endphp
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $siswa->nisn }}</td>
                                            <td>{{ $siswa->nama }}</td>
                                            <td>
                                                <select name="status[{{ $siswa->id }}]"
                                                    class="form-select status-select" required>
                                                    @foreach (\App\Models\Absensi::STATUS as $key => $label)
                                                        <option value="{{ $key }}"
                                                            @selected(old("status.{$siswa->id}", $dataLama->status ?? 'hadir') === $key)>
                                                            {{ $label }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text"
                                                    name="keterangan[{{ $siswa->id }}]"
                                                    class="form-control"
                                                    maxlength="255"
                                                    value="{{ old("keterangan.{$siswa->id}", $dataLama->keterangan ?? '') }}"
                                                    placeholder="Opsional">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <a href="{{ route('admin.absensi.index') }}"
                                class="btn btn-outline-secondary">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Simpan Absensi
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    @endif
</div>

<script>
document.getElementById('tandaiSemuaHadir')?.addEventListener('click', function () {
    document.querySelectorAll('.status-select').forEach(function (select) {
        select.value = 'hadir';
    });
});
</script>
@endsection
