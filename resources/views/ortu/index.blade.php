
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cek Absensi Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-primary">
    <div class="container">
        <span class="navbar-brand mb-0 h1">Absensi Siswa</span>
        <a href="{{ route('home') }}" class="btn btn-outline-light btn-sm">
            Halaman Utama
        </a>
    </div>
</nav>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">

            <div class="card shadow-sm mb-4">
                <div class="card-body p-4">
                    <h3 class="mb-2">Cek Absensi Siswa</h3>
                    <p class="text-muted">
                        Masukkan NISN siswa untuk melihat riwayat kehadiran.
                    </p>

                    <form method="GET" action="{{ route('ortu.index') }}">
                        <div class="mb-3">
                            <label for="nisn" class="form-label">NISN Siswa</label>
                            <input
                                type="text"
                                name="nisn"
                                id="nisn"
                                class="form-control"
                                value="{{ request('nisn') }}"
                                maxlength="20"
                                required
                                placeholder="Masukkan NISN"
                            >
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Cari Data Absensi
                        </button>
                    </form>
                </div>
            </div>

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if ($siswa)
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5>Data Siswa</h5>
                        <p><strong>Nama:</strong> {{ $siswa->nama }}</p>
                        <p><strong>NISN:</strong> {{ $siswa->nisn }}</p>
                        <p class="mb-0"><strong>Kelas:</strong> {{ $siswa->kelas }}</p>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    @foreach ([
                        'hadir' => ['Hadir', 'success'],
                        'sakit' => ['Sakit', 'warning'],
                        'izin' => ['Izin', 'info'],
                        'alpa' => ['Alpa', 'danger'],
                    ] as $status => [$label, $warna])
                        <div class="col-md-3 col-6">
                            <div class="card shadow-sm h-100">
                                <div class="card-body">
                                    <p class="text-muted mb-1">{{ $label }}</p>
                                    <h3 class="mb-0">
                                        {{ $rekap[$status] ?? 0 }}
                                    </h3>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="card shadow-sm">
                    <div class="card-header">
                        <strong>Riwayat Absensi</strong>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Guru</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($absensis as $absensi)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($absensi->tanggal)->format('d-m-Y') }}</td>
                                        <td>{{ $absensi->mapel_nama }}</td>
                                        <td>{{ $absensi->guru_nama }}</td>
                                        <td>{{ ucfirst($absensi->status) }}</td>
                                        <td>{{ $absensi->keterangan ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-3">
                                            Belum ada riwayat absensi.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="card-body">
                        {{ $absensis->links() }}
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>

</body>
</html>
