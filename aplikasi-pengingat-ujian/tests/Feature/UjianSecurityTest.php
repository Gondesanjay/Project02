<?php

namespace Tests\Feature;

use App\Models\MataPelajaran;
use App\Models\Ujian;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UjianSecurityTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Skenario Negatif: Pengguna TIDAK BISA menghapus ujian milik orang lain.
     */
    public function test_pengguna_tidak_bisa_menghapus_ujian_milik_pengguna_lain(): void
    {
        // ARRANGE
        $userA = User::factory()->create();
        $userB = User::factory()->create();
        $mataPelajaran = MataPelajaran::factory()->create(['user_id' => $userB->id]);
        $ujianMilikUserB = Ujian::factory()->create([
            'user_id' => $userB->id,
            'mata_pelajaran_id' => $mataPelajaran->id,
        ]);

        // ACT
        $response = $this->actingAs($userA)->delete('/ujian/' . $ujianMilikUserB->id);

        // ASSERT
        $response->assertStatus(403);
    }

    /**
     * Skenario Positif: Pengguna BISA menghapus ujian miliknya sendiri.
     */
    public function test_pengguna_bisa_menghapus_ujian_miliknya_sendiri(): void
    {
        // ARRANGE
        $user = User::factory()->create();
        $mataPelajaran = MataPelajaran::factory()->create(['user_id' => $user->id]);
        $ujianMilikSendiri = Ujian::factory()->create([
            'user_id' => $user->id,
            'mata_pelajaran_id' => $mataPelajaran->id,
        ]);

        // ACT
        $response = $this->actingAs($user)->delete('/ujian/' . $ujianMilikSendiri->id);

        // ASSERT
        // Kita berharap aksi ini BERHASIL dan diarahkan kembali (redirect).
        // Respons redirect biasanya memiliki status 302.
        $response->assertStatus(302);
        $response->assertRedirect('/ujian'); // Pastikan diarahkan ke halaman daftar ujian

        // Pastikan datanya sudah BENAR-BENAR TERHAPUS dari database.
        $this->assertDatabaseMissing('ujians', [
            'id' => $ujianMilikSendiri->id,
        ]);
    }
}
