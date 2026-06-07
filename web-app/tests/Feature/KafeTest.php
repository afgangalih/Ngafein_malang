<?php

namespace Tests\Feature;

use App\Models\KafeModel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KafeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_only_retrieve_approved_cafes_using_approved_scope()
    {
        // 1. Create a User
        $user = User::factory()->create();

        // 2. Create an approved cafe
        $approvedCafe = KafeModel::create([
            'nama_kafe' => 'Kafe Approved',
            'alamat' => 'Jl. Approved No. 1',
            'link_maps' => 'https://maps.google.com/?q=kafe-approved',
            'status' => 'approved',
            'user_id' => $user->id,
        ]);

        // 3. Create a pending cafe
        $pendingCafe = KafeModel::create([
            'nama_kafe' => 'Kafe Pending',
            'alamat' => 'Jl. Pending No. 2',
            'link_maps' => 'https://maps.google.com/?q=kafe-pending',
            'status' => 'pending',
            'user_id' => $user->id,
        ]);

        // 4. Retrieve cafes using approved scope
        $cafes = KafeModel::approved()->get();

        // 5. Assertions
        $this->assertTrue($cafes->contains($approvedCafe));
        $this->assertFalse($cafes->contains($pendingCafe));
    }

    /** @test */
    public function it_can_soft_delete_a_cafe()
    {
        // 1. Create a User
        $user = User::factory()->create();

        // 2. Create a cafe
        $cafe = KafeModel::create([
            'nama_kafe' => 'Kafe Yang Akan Dihapus',
            'alamat' => 'Jl. Hapus No. 10',
            'link_maps' => 'https://maps.google.com/?q=kafe-hapus',
            'status' => 'approved',
            'user_id' => $user->id,
        ]);

        // 3. Delete the cafe
        $cafe->delete();

        // 4. Assert it is soft deleted
        $this->assertSoftDeleted('kafe', [
            'id_kafe' => $cafe->id_kafe,
        ]);

        // 5. Verify it is not in the default query list but exists in database
        $this->assertNull(KafeModel::find($cafe->id_kafe));
        $this->assertNotNull(KafeModel::withTrashed()->find($cafe->id_kafe));
    }
}
