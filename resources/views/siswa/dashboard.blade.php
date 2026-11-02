
@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="container py-4">
    <h3>Dashboard Siswa</h3>
    <p>Selamat datang, {{ auth()->user()->name }}!</p>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5>Selamat Datang di Aplikasi Absensi Siswa</h5>
            <p class="mb-0">
                Silakan pilih menu untuk melihat informasi akademik Anda.
            </p>
        </div>
    </div>

    <div class="row g-3">

        {{-- Jadwal Pelajaran --}}
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5>Jadwal Pelajaran</h5>
                    <p>Lihat jadwal pelajaran sesuai kelas Anda.</p>
                    <a href="{{ route('siswa.jadwal.index') }}"
                       class="btn btn-primary">
                        Lihat Jadwal
                    </a>
                </div>
            </div>
        </div>

        {{-- Mata Pelajaran --}}
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5>Mata Pelajaran</h5>
                    <p>Lihat daftar mata pelajaran yang dipelajari.</p>
                    <a href="{{ route('siswa.mapel.index') }}"
                       class="btn btn-info">
                        Lihat Mata Pelajaran
                    </a>
                </div>
            </div>
        </div>

        {{-- Riwayat Absensi --}}
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5>Riwayat Absensi</h5>
                    <p>Lihat catatan kehadiran Anda.</p>
                    <a href="{{ route('siswa.absensi.index') }}"
                       class="btn btn-success">
                        Lihat Riwayat
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
