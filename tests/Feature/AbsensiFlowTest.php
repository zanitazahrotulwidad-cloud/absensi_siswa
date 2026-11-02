<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Jadwal;
use App\Models\Absensi;

class AbsensiFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dapat_membuka_form_input_absensi(): void
    {
        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
        ]);

        $this->actingAs($admin)
            ->get(route('admin.absensi.create'))
            ->assertOk();
    }

    public function test_guru_dapat_membuka_daftar_absensi(): void
    {
        $guru = User::factory()->create([
            'role' => User::ROLE_GURU,
        ]);

        Guru::factory()->create([
            'user_id' => $guru->id,
        ]);

        $this->actingAs($guru)
            ->get(route('guru.absensi.index'))
            ->assertOk();
    }

    public function test_siswa_dapat_membuka_riwayat_absensi_sendiri(): void
    {
        $siswa = User::factory()->create([
            'role' => User::ROLE_SISWA,
        ]);

        Siswa::factory()->create([
            'user_id' => $siswa->id,
        ]);

        $this->actingAs($siswa)
            ->get(route('siswa.absensi.index'))
            ->assertOk();
    }

    public function test_tamu_dapat_membuka_halaman_cek_absensi(): void
    {
        $this->get(route('ortu.index'))
            ->assertOk();
    }

    public function test_guru_tidak_dapat_mengakses_absensi_guru_lain(): void
    {
        $guruPertama = User::factory()->create([
            'role' => User::ROLE_GURU,
        ]);

        $profilGuruPertama = Guru::factory()->create([
            'user_id' => $guruPertama->id,
        ]);

        $guruKedua = User::factory()->create([
            'role' => User::ROLE_GURU,
        ]);

        $profilGuruKedua = Guru::factory()->create([
            'user_id' => $guruKedua->id,
        ]);

        $jadwalPertama = Jadwal::factory()->create([
            'guru_id' => $profilGuruPertama->id,
            'kelas' => 'X-A',
        ]);

        $jadwalKedua = Jadwal::factory()->create([
            'guru_id' => $profilGuruKedua->id,
            'kelas' => 'X-A',
        ]);

        $siswaPertama = Siswa::factory()->create([
            'nama' => 'Siswa Guru Pertama',
            'kelas' => 'X-A',
        ]);

        $siswaKedua = Siswa::factory()->create([
            'nama' => 'Siswa Guru Kedua',
            'kelas' => 'X-A',
        ]);

        Absensi::factory()->create([
            'jadwal_id' => $jadwalPertama->id,
            'siswa_id' => $siswaPertama->id,
        ]);

        Absensi::factory()->create([
            'jadwal_id' => $jadwalKedua->id,
            'siswa_id' => $siswaKedua->id,
        ]);

        $this->actingAs($guruPertama)
            ->get(route('guru.absensi.index'))
            ->assertOk()
            ->assertSee('Siswa Guru Pertama')
            ->assertDontSee('Siswa Guru Kedua');
    }

    public function test_halaman_cek_absensi_menerima_nisn(): void
    {
        Siswa::factory()->create([
            'nisn' => '1234567890',
        ]);

        $this->get(route('ortu.index', [
            'nisn' => '1234567890',
        ]))->assertOk();
    }

    public function test_guru_dapat_menyimpan_absensi_dan_memperbarui_data_lama(): void
    {
        $userGuru = User::factory()->create([
            'role' => User::ROLE_GURU,
        ]);

        $guru = Guru::factory()->create([
            'user_id' => $userGuru->id,
        ]);

        $jadwal = Jadwal::factory()->create([
            'guru_id' => $guru->id,
            'kelas' => 'X-A',
        ]);

        $siswa = Siswa::factory()->create([
            'kelas' => 'X-A',
        ]);

        $dataAbsensi = [
            'jadwal_id' => $jadwal->id,
            'tanggal' => '2026-10-31',
            'status' => [
                $siswa->id => 'hadir',
            ],
            'keterangan' => [
                $siswa->id => 'Hadir tepat waktu',
            ],
        ];

        $this->actingAs($userGuru)
            ->post(route('guru.absensi.store'), $dataAbsensi)
            ->assertRedirect(route('guru.absensi.index', [
                'jadwal_id' => $jadwal->id,
                'tanggal' => '2026-10-31',
            ]));

        $this->assertDatabaseHas('absensi', [
            'jadwal_id' => $jadwal->id,
            'siswa_id' => $siswa->id,
            'tanggal' => '2026-10-31',
            'status' => 'hadir',
        ]);

        $dataAbsensi['status'][$siswa->id] = 'izin';

        $this->actingAs($userGuru)
            ->post(route('guru.absensi.store'), $dataAbsensi)
            ->assertRedirect();

        $this->assertDatabaseHas('absensi', [
            'jadwal_id' => $jadwal->id,
            'siswa_id' => $siswa->id,
            'tanggal' => '2026-10-31',
            'status' => 'izin',
        ]);

        $this->assertDatabaseCount('absensi', 1);
    }

    public function test_guru_tidak_dapat_mengubah_absensi_guru_lain(): void
    {
        $userGuruPertama = User::factory()->create([
            'role' => User::ROLE_GURU,
        ]);

        $guruPertama = Guru::factory()->create([
            'user_id' => $userGuruPertama->id,
        ]);

        $userGuruKedua = User::factory()->create([
            'role' => User::ROLE_GURU,
        ]);

        $guruKedua = Guru::factory()->create([
            'user_id' => $userGuruKedua->id,
        ]);

        $jadwal = Jadwal::factory()->create([
            'guru_id' => $guruKedua->id,
            'kelas' => 'X-A',
        ]);

        $siswa = Siswa::factory()->create([
            'kelas' => 'X-A',
        ]);

        $absensi = Absensi::factory()->create([
            'jadwal_id' => $jadwal->id,
            'siswa_id' => $siswa->id,
            'status' => 'hadir',
        ]);

        $this->actingAs($userGuruPertama)
            ->put(route('guru.absensi.update', $absensi), [
                'status' => 'izin',
                'keterangan' => 'Percobaan mengubah data',
            ])
            ->assertForbidden();

        $this->assertDatabaseHas('absensi', [
            'id' => $absensi->id,
            'status' => 'hadir',
        ]);
    }

    public function test_guru_tidak_dapat_menghapus_absensi_guru_lain(): void
    {
        $userGuruPertama = User::factory()->create([
            'role' => User::ROLE_GURU,
        ]);

        Guru::factory()->create([
            'user_id' => $userGuruPertama->id,
        ]);

        $userGuruKedua = User::factory()->create([
            'role' => User::ROLE_GURU,
        ]);

        $guruKedua = Guru::factory()->create([
            'user_id' => $userGuruKedua->id,
        ]);

        $jadwal = Jadwal::factory()->create([
            'guru_id' => $guruKedua->id,
            'kelas' => 'X-A',
        ]);

        $siswa = Siswa::factory()->create([
            'kelas' => 'X-A',
        ]);

        $absensi = Absensi::factory()->create([
            'jadwal_id' => $jadwal->id,
            'siswa_id' => $siswa->id,
            'status' => 'hadir',
        ]);

        $this->actingAs($userGuruPertama)
            ->delete(route('guru.absensi.destroy', $absensi))
            ->assertForbidden();

        $this->assertDatabaseHas('absensi', [
            'id' => $absensi->id,
            'status' => 'hadir',
        ]);
    }
}
