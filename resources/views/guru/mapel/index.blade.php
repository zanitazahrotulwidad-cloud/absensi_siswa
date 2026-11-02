
@extends('layouts.app')

@section('title', 'Mata Pelajaran yang Diampu')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Mata Pelajaran yang Diampu</h3>

        <a href="{{ route('guru.dashboard') }}" class="btn btn-secondary">
            Kembali
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h6 class="mb-0 text-dark">Daftar Mata Pelajaran</h6>
        </div>

        <div class="card-body">
            @if ($mapel->isEmpty())
                <div class="alert alert-info mb-0">
                    Belum ada mata pelajaran yang diampu.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No.</th>
                                <th>Kode Mapel</th>
                                <th>Nama Mata Pelajaran</th>
                                <th>Jumlah Kelas</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($mapel as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->kode }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->jumlah_kelas }} kelas</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
