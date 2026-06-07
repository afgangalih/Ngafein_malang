<?php

namespace Tests\Feature\Api\User;

use App\Models\FasilitasModel;
use App\Models\KafeGambarModel;
use App\Models\KafeModel;
use App\Models\MenuModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KafeApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function search_returns_matching_approved_cafes_with_complete_fields(): void
    {
        $approved = $this->createCafe([
            'nama_kafe' => 'Kafe Kopi Senja',
            'status' => 'approved',
        ]);
        $this->createCafe([
            'nama_kafe' => 'Kafe Kopi Pending',
            'status' => 'pending',
        ]);

        $response = $this->getJson('/api/kafe/search?q=kopi');

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('meta.total', 1)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id_kafe',
                        'nama_kafe',
                        'alamat',
                        'link_maps',
                        'harga_min',
                        'harga_max',
                        'rating',
                        'jarak',
                        'jam_buka',
                        'jam_tutup',
                        'deskripsi',
                        'status',
                        'user_id',
                        'created_at',
                        'updated_at',
                        'fasilitas',
                        'menus',
                        'gambar',
                    ],
                ],
            ]);

        $ids = collect($response->json('data'))->pluck('id_kafe');
        $this->assertTrue($ids->contains($approved->id_kafe));
        $this->assertCount(1, $ids);
    }

    /** @test */
    public function search_returns_empty_array_when_query_is_too_short(): void
    {
        $this->createCafe(['nama_kafe' => 'Kafe Kopi Senja']);

        $this->getJson('/api/kafe/search?q=k')
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data', [])
            ->assertJsonPath('meta.total', 0);
    }

    /** @test */
    public function detail_returns_approved_cafe_with_relations(): void
    {
        $cafe = $this->createCafe(['nama_kafe' => 'Kafe Detail']);
        $fasilitas = FasilitasModel::create([
            'id_fasilitas' => 1,
            'nama_fasilitas' => 'Wifi',
        ]);
        $menu = MenuModel::create([
            'id_menu' => 1,
            'nama_menu' => 'Kopi Susu',
        ]);
        $cafe->fasilitas()->attach($fasilitas->id_fasilitas);
        $cafe->menus()->attach($menu->id_menu);
        KafeGambarModel::create([
            'id_kafe' => $cafe->id_kafe,
            'path_gambar' => 'cafes/detail.jpg',
        ]);

        $this->getJson("/api/kafe/{$cafe->id_kafe}")
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.id_kafe', $cafe->id_kafe)
            ->assertJsonPath('data.nama_kafe', 'Kafe Detail')
            ->assertJsonPath('data.fasilitas.0.nama_fasilitas', 'Wifi')
            ->assertJsonPath('data.menus.0.nama_menu', 'Kopi Susu')
            ->assertJsonPath('data.gambar.0.path_gambar', 'cafes/detail.jpg');
    }

    /** @test */
    public function detail_does_not_return_pending_cafe(): void
    {
        $cafe = $this->createCafe([
            'nama_kafe' => 'Kafe Pending',
            'status' => 'pending',
        ]);

        $this->getJson("/api/kafe/{$cafe->id_kafe}")
            ->assertNotFound();
    }

    private function createCafe(array $attributes = []): KafeModel
    {
        return KafeModel::create(array_merge([
            'nama_kafe' => 'Kafe Uji',
            'alamat' => 'Jl. Testing No. 1',
            'link_maps' => 'https://maps.google.com/?q=kafe-uji',
            'harga_min' => 15000,
            'harga_max' => 35000,
            'rating' => 4.5,
            'jarak' => 1.2,
            'jam_buka' => '08:00',
            'jam_tutup' => '22:00',
            'deskripsi' => 'Kafe untuk kebutuhan testing.',
            'status' => 'approved',
        ], $attributes));
    }
}
