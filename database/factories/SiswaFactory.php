<?php

namespace Database\Factories;

use App\Models\Siswa;
use Illuminate\Database\Eloquent\Factories\Factory;

class SiswaFactory extends Factory
{
    protected $model = Siswa::class;

    public function definition(): array
    {
        return [
            'nisn' => fake()->unique()->numerify('##########'),
            'nama' => fake()->name(),
            'kelas' => fake()->randomElement(['X-A', 'X-B', 'XI-A', 'XI-B', 'XII-A']),
            'jenis_kelamin' => fake()->randomElement(['L', 'P']),
            'tanggal_lahir' => fake()->date(),
            'alamat' => fake()->address(),
        ];
    }
}