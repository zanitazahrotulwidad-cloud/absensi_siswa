@extends('layouts.app')

@section('title', 'Dashboard Guru')

@section('content')
    <div class="mb-4">
        <h1 class="h3">Dashboard Guru</h1>
        <p class="text-muted">Selamat datang di aplikasi Absensi Siswa.</p>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Jadwal Mengajar</h5>
                    <p class="card-text">Lihat jadwal mengajar Anda.</p>
                    <span class="badge text-bg-success">Guru</span>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Absensi Siswa</h5>
                    <p class="card-text">Kelola kehadiran siswa.</p>
                    <span class="badge text-bg-success">Guru</span>
                </div>
            </div>
        </div>
    </div>
@endsection
