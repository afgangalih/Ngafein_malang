<?php

namespace Tests\Feature\Api\User;

use App\Models\KafeModel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class RekomendasiApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function recommendation_api_returns_ranked_approved_cafes_from_saw_engine(): void
    {
        $user = User::factory()->create(['role' => 'mahasiswa']);
        $approved = $this->createCafe(['nama_kafe' => 'Kafe Approved', 'status' => 'approved']);
        $this->createCafe(['nama_kafe' => 'Kafe Pending', 'status' => 'pending']);

        Http::fake(fn ($request) => Http::response([
            'hasil' => collect($request->data()['cafes'])->map(fn ($cafe, $idx) => array_merge($cafe, [
                'skor' => 0.9 - ($idx * 0.1),
                'ranking' => $idx + 1,
            ]))->values()->all(),
            'matriks' => [],
            'normalisasi' => [],
        ], 200));

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/rekomendasi');

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('meta.engine_error', null)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id_kafe', 'nama_kafe', 'skor', 'ranking', 'rating_raw', 'jarak_km'],
                ],
                'meta' => ['total', 'engine_error'],
            ]);

        $ids = collect($response->json('data'))->pluck('id_kafe');
        $this->assertTrue($ids->contains($approved->id_kafe));
        $this->assertCount(1, $ids);
    }

    /** @test */
    public function recommendation_api_applies_preference_filters(): void
    {
        $user = User::factory()->create(['role' => 'mahasiswa']);
        $match = $this->createCafe([
            'nama_kafe' => 'Kafe Cocok',
            'harga_min' => 20000,
            'jarak' => 1.0,
            'rating' => 4.5,
        ]);
        $this->createCafe([
            'nama_kafe' => 'Kafe Terlalu Mahal',
            'harga_min' => 60000,
            'jarak' => 1.0,
            'rating' => 4.8,
        ]);
        $this->createCafe([
            'nama_kafe' => 'Kafe Terlalu Jauh',
            'harga_min' => 15000,
            'jarak' => 5.0,
            'rating' => 4.8,
        ]);

        Http::fake(['*' => Http::response(['error' => 'engine down'], 500)]);
        Sanctum::actingAs($user);

        $response = $this->getJson('/api/rekomendasi?harga_max=30000&jarak_max=2&rating_min=4');

        $response->assertOk()
            ->assertJsonPath('success', true);

        $ids = collect($response->json('data'))->pluck('id_kafe');
        $this->assertTrue($ids->contains($match->id_kafe));
        $this->assertCount(1, $ids);
    }

    /** @test */
    public function recommendation_api_excludes_authenticated_users_blacklisted_cafes(): void
    {
        $user = User::factory()->create(['role' => 'mahasiswa']);
        $visible = $this->createCafe(['nama_kafe' => 'Kafe Tampil']);
        $hidden = $this->createCafe(['nama_kafe' => 'Kafe Blacklist']);
        $user->blacklistedCafes()->attach($hidden->id_kafe);

        Http::fake(['*' => Http::response(['error' => 'engine down'], 500)]);
        Sanctum::actingAs($user);

        $response = $this->getJson('/api/rekomendasi');

        $response->assertOk();

        $ids = collect($response->json('data'))->pluck('id_kafe');
        $this->assertTrue($ids->contains($visible->id_kafe));
        $this->assertFalse($ids->contains($hidden->id_kafe));
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
