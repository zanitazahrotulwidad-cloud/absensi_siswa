<?php

namespace Database\Factories;

use App\Models\Mapel;
use Illuminate\Database\Eloquent\Factories\Factory;

class MapelFactory extends Factory
{
    protected $model = Mapel::class;

    public function definition(): array
    {
        return [
            'kode' => fake()->unique()->bothify('MP###'),
            'nama' => fake()->randomElement([
                'Matematika',
                'Bahasa Indonesia',
                'Bahasa Inggris',
                'IPA',
                'IPS',
            ]),
        ];
    }
}