<?php

namespace Tests\Unit;

use App\Helpers\MenuHelper;
use Illuminate\Http\Request;
use Tests\TestCase;

class MenuHelperTest extends TestCase
{
    /**
     * @test
     * Memastikan getMainNavItems mengembalikan daftar menu utama dengan field yang tepat.
     */
    public function test_get_main_nav_items_returns_valid_structure(): void
    {
        $items = MenuHelper::getMainNavItems();

        $this->assertIsArray($items);
        $this->assertNotEmpty($items);

        foreach ($items as $item) {
            $this->assertArrayHasKey('icon', $item);
            $this->assertArrayHasKey('name', $item);
            $this->assertArrayHasKey('path', $item);
        }
    }

    /**
     * @test
     * Memastikan getMenuGroups mengembalikan struktur kelompok menu yang sesuai.
     */
    public function test_get_menu_groups_has_correct_keys(): void
    {
        $groups = MenuHelper::getMenuGroups();

        $this->assertIsArray($groups);
        $this->assertNotEmpty($groups);

        foreach ($groups as $group) {
            $this->assertArrayHasKey('title', $group);
            $this->assertArrayHasKey('items', $group);
            $this->assertIsArray($group['items']);
        }
    }

    /**
     * @test
     * Memastikan pencarian ikon SVG yang terdaftar sukses mengembalikan string tag svg,
     * dan ikon yang tidak terdaftar mengembalikan SVG fallback.
     */
    public function test_get_icon_svg_returns_correct_svg_markup(): void
    {
        // Ikon valid terdaftar
        $dashboardSvg = MenuHelper::getIconSvg('dashboard');
        $this->assertStringContainsString('<svg', $dashboardSvg);
        $this->assertStringContainsString('viewBox="0 0 24 24"', $dashboardSvg);

        // Ikon invalid (fallback)
        $fallbackSvg = MenuHelper::getIconSvg('random-icon-xyz');
        $this->assertStringContainsString('<svg', $fallbackSvg);
        // Fallback default star icon path contains 'd="M12 2l3.09'
        $this->assertStringContainsString('d="M12 2l3.09', $fallbackSvg);
    }

    /**
     * @test
     * Memastikan method isActive mendeteksi status aktif berdasarkan path url request saat ini.
     */
    public function test_is_active_detects_request_path_correctly(): void
    {
        // Mock request path di Laravel
        $this->get('/admin/dashboard');

        // Path /admin/dashboard harus aktif
        $this->assertTrue(MenuHelper::isActive('/admin/dashboard'));
        $this->assertTrue(MenuHelper::isActive('admin/dashboard'));

        // Path lain harus tidak aktif
        $this->assertFalse(MenuHelper::isActive('/admin/users'));
    }
}
