<?php

namespace Tests\Feature\Api\User;

use App\Models\KafeModel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class BlacklistApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cannot_blacklist_a_cafe(): void
    {
        $cafe = $this->createCafe();

        $this->postJson("/api/kafe/{$cafe->id_kafe}/blacklist")
            ->assertUnauthorized();
    }

    /** @test */
    public function mahasiswa_can_toggle_cafe_blacklist(): void
    {
        $user = User::factory()->create(['role' => 'mahasiswa']);
        $cafe = $this->createCafe();

        Sanctum::actingAs($user);

        $this->postJson("/api/kafe/{$cafe->id_kafe}/blacklist")
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('blacklisted', true);

        $this->assertDatabaseHas('blacklist_kafe', [
            'user_id' => $user->id,
            'kafe_id' => $cafe->id_kafe,
        ]);

        $this->postJson("/api/kafe/{$cafe->id_kafe}/blacklist")
            ->assertOk()
            ->assertJsonPath('blacklisted', false);

        $this->assertDatabaseMissing('blacklist_kafe', [
            'user_id' => $user->id,
            'kafe_id' => $cafe->id_kafe,
        ]);
    }

    /** @test */
    public function blacklisting_a_favorite_cafe_removes_it_from_favorites(): void
    {
        $user = User::factory()->create(['role' => 'mahasiswa']);
        $cafe = $this->createCafe();
        $user->favorites()->attach($cafe->id_kafe);

        Sanctum::actingAs($user);

        $this->postJson("/api/kafe/{$cafe->id_kafe}/blacklist")
            ->assertOk()
            ->assertJsonPath('blacklisted', true);

        $this->assertDatabaseMissing('favorit_kafe', [
            'user_id' => $user->id,
            'kafe_id' => $cafe->id_kafe,
        ]);
    }

    private function createCafe(array $attributes = []): KafeModel
    {
        return KafeModel::create(array_merge([
            'nama_kafe' => 'Kafe Uji',
            'alamat' => 'Jl. Testing No. 1',
            'harga_min' => 15000,
            'harga_max' => 35000,
            'rating' => 4.5,
            'jarak' => 1.2,
            'jam_buka' => '08:00',
            'jam_tutup' => '22:00',
            'status' => 'approved',
        ], $attributes));
    }
}
