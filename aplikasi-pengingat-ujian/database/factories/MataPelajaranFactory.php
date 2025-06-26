<?php

namespace Database\Factories;

use App\Models\MataPelajaran;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MataPelajaran>
 */
class MataPelajaranFactory extends Factory
{
    /**
     * Tentukan model yang akan digunakan oleh factory ini.
     *
     * @var string
     */
    protected $model = MataPelajaran::class;

    /**
     * Definisikan "resep" untuk membuat data Mata Pelajaran palsu.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_mapel' => $this->faker->words(3, true), // cth: "Ilmu Komputer Lanjut"
            'nama_dosen' => 'Dr. ' . $this->faker->name(),
            'user_id' => \App\Models\User::factory(), // Otomatis buat user baru jika tidak disediakan
        ];
    }
}
