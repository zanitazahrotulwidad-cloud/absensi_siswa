<?php

namespace Database\Factories;

use App\Models\Guru;
use Illuminate\Database\Eloquent\Factories\Factory;

class GuruFactory extends Factory
{
    protected $model = Guru::class;

    public function definition(): array
    {
        return [
            'nip' => fake()->unique()->numerify('################'),
            'nama' => fake()->name(),
            'jenis_kelamin' => fake()->randomElement(['L', 'P']),
            'alamat' => fake()->address(),
        ];
    }
}