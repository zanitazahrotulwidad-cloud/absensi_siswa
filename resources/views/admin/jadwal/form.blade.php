
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">
            {{ $jadwal ? 'Edit Jadwal Pelajaran' : 'Tambah Jadwal Pelajaran' }}
        </h1>

        <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary">
            Kembali
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form
                action="{{ $jadwal ? route('admin.jadwal.update', $jadwal) : route('admin.jadwal.store') }}"
                method="POST"
            >
                @csrf

                @if ($jadwal)
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label for="mapel_id" class="form-label">Mata Pelajaran</label>
                    <select name="mapel_id" id="mapel_id"
                            class="form-select @error('mapel_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Mata Pelajaran --</option>
                        @foreach ($mapelList as $mapel)
                            <option value="{{ $mapel->id }}"
                                @selected(old('mapel_id', $jadwal?->mapel_id) == $mapel->id)>
                                {{ $mapel->kode }} - {{ $mapel->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('mapel_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="guru_id" class="form-label">Guru</label>
                    <select name="guru_id" id="guru_id"
                            class="form-select @error('guru_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Guru --</option>
                        @foreach ($guruList as $guru)
                            <option value="{{ $guru->id }}"
                                @selected(old('guru_id', $jadwal?->guru_id) == $guru->id)>
                                {{ $guru->nip }} - {{ $guru->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('guru_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="kelas" class="form-label">Kelas</label>
                    <input type="text" name="kelas" id="kelas"
                           list="daftarKelas"
                           value="{{ old('kelas', $jadwal?->kelas) }}"
                           class="form-control @error('kelas') is-invalid @enderror"
                           placeholder="Contoh: X-A" required>

                    <datalist id="daftarKelas">
                        @foreach ($kelasList as $kelas)
                            <option value="{{ $kelas }}"></option>
                        @endforeach
                    </datalist>

                    @error('kelas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="hari" class="form-label">Hari</label>
                    <select name="hari" id="hari"
                            class="form-select @error('hari') is-invalid @enderror" required>
                        <option value="">-- Pilih Hari --</option>
                        @foreach (\App\Models\Jadwal::HARI as $hari)
                            <option value="{{ $hari }}"
                                @selected(old('hari', $jadwal?->hari) === $hari)>
                                {{ $hari }}
                            </option>
                        @endforeach
                    </select>
                    @error('hari')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="jam_mulai" class="form-label">Jam Mulai</label>
                        <input type="time" name="jam_mulai" id="jam_mulai"
                               value="{{ old('jam_mulai', $jadwal?->jam_mulai ? substr($jadwal->jam_mulai, 0, 5) : '') }}"
                               class="form-control @error('jam_mulai') is-invalid @enderror"
                               required>
                        @error('jam_mulai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="jam_selesai" class="form-label">Jam Selesai</label>
                        <input type="time" name="jam_selesai" id="jam_selesai"
                               value="{{ old('jam_selesai', $jadwal?->jam_selesai ? substr($jadwal->jam_selesai, 0, 5) : '') }}"
                               class="form-control @error('jam_selesai') is-invalid @enderror"
                               required>
                        @error('jam_selesai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    {{ $jadwal ? 'Simpan Perubahan' : 'Simpan Jadwal' }}
                </button>

                <a href="{{ route('admin.jadwal.index') }}" class="btn btn-outline-secondary">
                    Batal
                </a>
            </form>
        </div>
    </div>
</div>
@endsection
