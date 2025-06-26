<?php

namespace Database\Factories;

use App\Models\Ujian;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ujian>
 */
class UjianFactory extends Factory
{
    /**
     * Tentukan model yang akan digunakan oleh factory ini.
     *
     * @var string
     */
    protected $model = Ujian::class;

    /**
     * Definisikan "resep" untuk membuat data Ujian palsu.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_ujian' => 'UAS ' . $this->faker->word(),
            'tanggal_ujian' => $this->faker->dateTimeBetween('+1 week', '+1 month'),
            'user_id' => \App\Models\User::factory(), // Otomatis buat user & mata pelajaran baru
            'mata_pelajaran_id' => \App\Models\MataPelajaran::factory(), // jika tidak disediakan
        ];
    }
}
