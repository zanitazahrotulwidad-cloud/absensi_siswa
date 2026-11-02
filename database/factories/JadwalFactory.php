<?php

namespace Database\Factories;

use App\Models\Jadwal;
use App\Models\Mapel;
use App\Models\Guru;
use Illuminate\Database\Eloquent\Factories\Factory;

class JadwalFactory extends Factory
{
    protected $model = Jadwal::class;

    public function definition(): array
    {
        return [
            'mapel_id' => Mapel::factory(),
            'guru_id' => Guru::factory(),
            'kelas' => fake()->randomElement(['X-A', 'X-B', 'XI-A']),
            'hari' => fake()->randomElement([
                'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'
            ]),
            'jam_mulai' => '07:00:00',
            'jam_selesai' => '08:30:00',
        ];
    }
}