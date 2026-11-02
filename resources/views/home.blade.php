
@extends('layouts.guest')

@section('title', 'Beranda')

@section('content')
    <div class="container">
        <section class="bg-primary text-white rounded-4 shadow-sm p-4 p-md-5 mb-3">
            <h1 class="fw-bold mb-2">Sistem Absensi Siswa</h1>

            <p class="mb-3">
                Aplikasi sederhana untuk mengelola jadwal, mata pelajaran,
                dan absensi siswa. Admin mengelola data, guru mengisi absensi,
                siswa dan orang tua memantau kehadiran.
            </p>

            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('login') }}"
                   class="btn btn-light text-primary fw-semibold">
                    Masuk
                </a>

                <a href="{{ route('ortu.index') }}"
                   class="btn btn-outline-light">
                    Cek Absensi Anak
                </a>
            </div>
        </section>

        <div class="row g-3">
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title">Manajemen Data</h5>
                        <p class="card-text text-muted small mb-0">
                            Admin mengelola data guru, siswa, mata pelajaran,
                            jadwal, dan absensi lengkap dengan CRUD.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title">Absensi oleh Guru</h5>
                        <p class="card-text text-muted small mb-0">
                            Guru mengisi kehadiran siswa per jadwal dan tanggal,
                            serta melihat jadwal dan mata pelajaran yang diajar.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title">Pantauan Siswa</h5>
                        <p class="card-text text-muted small mb-0">
                            Siswa dapat melihat jadwal kelas, daftar mata
                            pelajaran, dan riwayat absensinya sendiri.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title">Akses Orang Tua</h5>
                        <p class="card-text text-muted small mb-0">
                            Orang tua dapat memantau kehadiran anak melalui
                            fitur pengecekan absensi.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
