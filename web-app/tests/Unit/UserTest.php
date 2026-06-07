<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

/**
 * Unit Test untuk App\Models\User
 *
 * Menguji method peran (role) yang digunakan oleh middleware
 * IsAdmin dan IsMahasiswa. Tidak membutuhkan database.
 */
class UserTest extends TestCase
{
    // =========================================================================
    // POSITIF: isAdmin()
    // =========================================================================

    /**
     * @test
     * User dengan role 'admin' seharusnya dikenali sebagai admin.
     */
    public function user_dengan_role_admin_dikenali_sebagai_admin(): void
    {
        $user = new User();
        $user->role = 'admin';

        $this->assertTrue($user->isAdmin());
    }

    // =========================================================================
    // NEGATIF: isAdmin()
    // =========================================================================

    /**
     * @test
     * User dengan role 'mahasiswa' seharusnya TIDAK dikenali sebagai admin.
     */
    public function user_dengan_role_mahasiswa_bukan_admin(): void
    {
        $user = new User();
        $user->role = 'mahasiswa';

        $this->assertFalse($user->isAdmin());
    }

    /**
     * @test
     * User dengan role kosong/tidak diset seharusnya TIDAK dikenali sebagai admin.
     */
    public function user_tanpa_role_bukan_admin(): void
    {
        $user = new User();
        $user->role = null;

        $this->assertFalse($user->isAdmin());
    }

    // =========================================================================
    // POSITIF: isMahasiswa()
    // =========================================================================

    /**
     * @test
     * User dengan role 'mahasiswa' seharusnya dikenali sebagai mahasiswa.
     */
    public function user_dengan_role_mahasiswa_dikenali_sebagai_mahasiswa(): void
    {
        $user = new User();
        $user->role = 'mahasiswa';

        $this->assertTrue($user->isMahasiswa());
    }

    // =========================================================================
    // NEGATIF: isMahasiswa()
    // =========================================================================

    /**
     * @test
     * User dengan role 'admin' seharusnya TIDAK dikenali sebagai mahasiswa.
     */
    public function user_dengan_role_admin_bukan_mahasiswa(): void
    {
        $user = new User();
        $user->role = 'admin';

        $this->assertFalse($user->isMahasiswa());
    }

    /**
     * @test
     * User dengan role kosong/tidak diset seharusnya TIDAK dikenali sebagai mahasiswa.
     */
    public function user_tanpa_role_bukan_mahasiswa(): void
    {
        $user = new User();
        $user->role = null;

        $this->assertFalse($user->isMahasiswa());
    }
}
