<?php

namespace Database\Factories;

use App\Models\Absensi;
use App\Models\Jadwal;
use App\Models\Siswa;
use Illuminate\Database\Eloquent\Factories\Factory;

class AbsensiFactory extends Factory
{
    protected $model = Absensi::class;

    public function definition(): array
    {
        return [
            'siswa_id' => Siswa::factory(),
            'jadwal_id' => Jadwal::factory(),
            'tanggal' => fake()->date(),
            'status' => fake()->randomElement([
                'hadir',
                'sakit',
                'izin',
                'alpa',
            ]),
            'keterangan' => fake()->optional()->sentence(),
        ];
    }
}