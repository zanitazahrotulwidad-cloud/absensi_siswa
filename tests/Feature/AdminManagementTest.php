<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Mapel;
use App\Models\Jadwal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
        ]);

        $this->actingAs($admin);
    }

    public function test_admin_dapat_melihat_daftar_guru(): void
    {
        $this->get(route('admin.guru.index'))
            ->assertOk();
    }

    public function test_admin_dapat_melihat_daftar_siswa(): void
    {
        $this->get(route('admin.siswa.index'))
            ->assertOk();
    }

    public function test_admin_dapat_melihat_daftar_mapel(): void
    {
        $this->get(route('admin.mapel.index'))
            ->assertOk();
    }

    public function test_admin_dapat_melihat_daftar_jadwal(): void
    {
        $this->get(route('admin.jadwal.index'))
            ->assertOk();
    }

    public function test_admin_dapat_melihat_daftar_absensi(): void
    {
        $this->get(route('admin.absensi.index'))
            ->assertOk();
    }

    public function test_admin_dapat_membuka_form_tambah_guru(): void
    {
        $this->get(route('admin.guru.create'))
            ->assertOk();
    }

    public function test_admin_dapat_membuka_form_tambah_siswa(): void
    {
        $this->get(route('admin.siswa.create'))
            ->assertOk();
    }

    public function test_admin_dapat_membuka_form_tambah_jadwal(): void
    {
        $this->get(route('admin.jadwal.create'))
            ->assertOk();
    }

    public function test_admin_bisa_menambah_mengubah_dan_menghapus_mapel(): void
    {
        // Tambah mapel
        $this->post(route('admin.mapel.store'), [
            'kode' => 'MAT-01',
            'nama' => 'Matematika',
        ])->assertRedirect(route('admin.mapel.index'));

        $this->assertDatabaseHas('mapel', [
            'kode' => 'MAT-01',
            'nama' => 'Matematika',
        ]);

        // Ambil mapel yang baru dibuat
        $mapel = Mapel::where('kode', 'MAT-01')->firstOrFail();

        // Ubah mapel
        $this->put(route('admin.mapel.update', $mapel), [
            'kode' => 'MAT-02',
            'nama' => 'Matematika Lanjut',
        ])->assertRedirect(route('admin.mapel.index'));

        $this->assertDatabaseHas('mapel', [
            'id' => $mapel->id,
            'kode' => 'MAT-02',
            'nama' => 'Matematika Lanjut',
        ]);

        // Hapus mapel
        $this->delete(route('admin.mapel.destroy', $mapel))
            ->assertRedirect(route('admin.mapel.index'));

        $this->assertDatabaseMissing('mapel', [
            'id' => $mapel->id,
        ]);
    }

    public function test_mapel_tidak_bisa_dihapus_jika_sudah_digunakan_jadwal(): void
    {
        $mapel = Mapel::factory()->create();

        Jadwal::factory()->create([
            'mapel_id' => $mapel->id,
        ]);

        $this->delete(route('admin.mapel.destroy', $mapel));

        $this->assertDatabaseHas('mapel', [
            'id' => $mapel->id,
        ]);
    }

    public function test_admin_dapat_membuat_guru_beserta_akun_login(): void
    {
        $this->post(route('admin.guru.store'), [
            'nip' => '1987654321',
            'nama' => 'Guru Pengujian',
            'jenis_kelamin' => 'L',
            'alamat' => 'Kraksaan',
            'email' => 'guru.pengujian@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])->assertRedirect(route('admin.guru.index'));

        $this->assertDatabaseHas('guru', [
            'nip' => '1987654321',
            'nama' => 'Guru Pengujian',
        ]);

        $this->assertDatabaseHas('user', [
            'email' => 'guru.pengujian@example.com',
            'role' => User::ROLE_GURU,
        ]);
    }

    public function test_admin_dapat_membuat_siswa_beserta_akun_login(): void
    {
        $this->post(route('admin.siswa.store'), [
            'nisn' => '1234567890',
            'nama' => 'Siswa Pengujian',
            'kelas' => 'X-A',
            'jenis_kelamin' => 'L',
            'tanggal_lahir' => '2010-05-15',
            'alamat' => 'Kraksaan',
            'email' => 'siswa.pengujian@example.com',
            'password' => 'password123',
        ])->assertRedirect(route('admin.siswa.index'));

        $this->assertDatabaseHas('siswa', [
            'nisn' => '1234567890',
            'nama' => 'Siswa Pengujian',
            'kelas' => 'X-A',
        ]);

        $this->assertDatabaseHas('user', [
            'email' => 'siswa.pengujian@example.com',
            'role' => User::ROLE_SISWA,
        ]);
    }

    public function test_admin_dapat_membuat_jadwal_pelajaran(): void
    {
        $mapel = Mapel::factory()->create();
        $guru = Guru::factory()->create();

        $this->post(route('admin.jadwal.store'), [
            'mapel_id' => $mapel->id,
            'guru_id' => $guru->id,
            'kelas' => 'X-A',
            'hari' => 'Senin',
            'jam_mulai' => '07:00',
            'jam_selesai' => '08:30',
        ])->assertRedirect(route('admin.jadwal.index'));

        $this->assertDatabaseHas('jadwal', [
            'mapel_id' => $mapel->id,
            'guru_id' => $guru->id,
            'kelas' => 'X-A',
            'hari' => 'Senin',
            'jam_mulai' => '07:00',
            'jam_selesai' => '08:30',
        ]);
    }

    public function test_jadwal_ditolak_jika_guru_memiliki_jadwal_bentrok(): void
    {
        $mapel = Mapel::factory()->create();
        $guru = Guru::factory()->create();

        Jadwal::factory()->create([
            'mapel_id' => $mapel->id,
            'guru_id' => $guru->id,
            'kelas' => 'X-A',
            'hari' => 'Senin',
            'jam_mulai' => '07:00',
            'jam_selesai' => '08:30',
        ]);

        $mapelBaru = Mapel::factory()->create();

        $response = $this->from(route('admin.jadwal.create'))
            ->post(route('admin.jadwal.store'), [
                'mapel_id' => $mapelBaru->id,
                'guru_id' => $guru->id,
                'kelas' => 'X-B',
                'hari' => 'Senin',
                'jam_mulai' => '07:00',
                'jam_selesai' => '08:30',
            ]);

        $response->assertRedirect(route('admin.jadwal.create'));
        $response->assertSessionHasErrors('jam_mulai');

        $this->assertDatabaseCount('jadwal', 1);
    }

    public function test_siswa_tidak_bisa_dihapus_jika_sudah_memiliki_absensi(): void
    {
        $siswa = Siswa::factory()->create();
        $mapel = Mapel::factory()->create();
        $guru = Guru::factory()->create();

        $jadwal = Jadwal::factory()->create([
            'mapel_id' => $mapel->id,
            'guru_id' => $guru->id,
            'kelas' => $siswa->kelas,
        ]);

        \App\Models\Absensi::factory()->create([
            'siswa_id' => $siswa->id,
            'jadwal_id' => $jadwal->id,
        ]);

        $this->delete(route('admin.siswa.destroy', $siswa))
            ->assertRedirect(route('admin.siswa.index'));

        $this->assertDatabaseHas('siswa', [
            'id' => $siswa->id,
        ]);
    }
}