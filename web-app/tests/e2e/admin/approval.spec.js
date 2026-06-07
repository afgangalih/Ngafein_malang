// @ts-check
import { test, expect } from '@playwright/test';

test.describe('Fitur Persetujuan Admin (Approval)', () => {

  test('Pengujian Negatif - Mahasiswa ditolak masuk dashboard admin', async ({ page }) => {
    // 1. Login sebagai mahasiswa
    await page.goto('/');
    await page.locator('nav').getByRole('button', { name: 'Masuk', exact: true }).click();
    
    const loginForm = page.locator('form').filter({ has: page.getByRole('button', { name: 'Masuk' }) });
    await loginForm.locator('input[type="email"]').fill('mahasiswa@gmail.com');
    await loginForm.locator('input[type="password"]').fill('pass123');
    await loginForm.getByRole('button', { name: 'Masuk' }).click();

    // Tunggu login
    const avatarButton = page.locator('nav').locator('div.relative button').filter({ has: page.locator('svg') }).first();
    await expect(avatarButton).toBeVisible({ timeout: 10000 });

    // 2. Coba akses rute admin approval secara paksa
    await page.goto('/admin/approval');

    // 3. Karena mahasiswa, harusnya diblokir dengan error 403 atau diredirect kembali ke home/dashboard mahasiswa
    // Rute middleware admin akan melempar abort(403) atau redirect. Mari kita cek status/heading/URL.
    // Rute middleware admin akan melempar abort(403) atau redirect.
    await expect(page.locator('body')).toContainText('403');
  });

  test('Pengujian Positif - Admin sukses menyetujui usulan kafe mahasiswa', async ({ page }) => {
    // === LANGKAH 1: MAHASISWA MENGUSULKAN KAFE ===
    await page.goto('/');
    await page.locator('nav').getByRole('button', { name: 'Masuk', exact: true }).click();
    
    let loginForm = page.locator('form').filter({ has: page.getByRole('button', { name: 'Masuk' }) });
    await loginForm.locator('input[type="email"]').fill('mahasiswa@gmail.com');
    await loginForm.locator('input[type="password"]').fill('pass123');
    await loginForm.getByRole('button', { name: 'Masuk' }).click();

    // Tunggu login
    let avatarButton = page.locator('nav').locator('div.relative button').filter({ has: page.locator('svg') }).first();
    await expect(avatarButton).toBeVisible({ timeout: 10000 });

    // Pergi ke halaman usulan kafe
    await page.goto('/kafe/tambah');
    
    const timestamp = Date.now();
    const namaKafe = `Kafe E2E Approval ${timestamp}`;
    
    await page.locator('input[name="nama_kafe"]').fill(namaKafe);
    await page.locator('input[name="jarak"]').fill('1.8');
    await page.locator('input[name="rating"]').fill('4.7');
    await page.locator('input[name="jam_buka"]').fill('09:00');
    await page.locator('input[name="jam_tutup"]').fill('22:00');
    await page.locator('input[name="harga_min"]').fill('10000');
    await page.locator('input[name="harga_max"]').fill('30000');
    await page.locator('textarea[name="alamat"]').fill('Jalan Soekarno Hatta No. 12, Malang');
    
    // Kirim usulan
    await page.getByRole('button', { name: 'Kirim Usulan Kafe' }).click();
    await expect(page.locator('text=Berhasil!')).toBeVisible({ timeout: 10000 });

    // Logout mahasiswa
    await avatarButton.click();
    const dropdownMenu = page.locator('div[x-show="open"]').first();
    await expect(dropdownMenu).toBeVisible({ timeout: 5000 });
    const logoutBtn = dropdownMenu.locator('button:has-text("Keluar")');
    await logoutBtn.click();
    await page.waitForURL('/');

    // === LANGKAH 2: ADMIN MASUK DAN APPROVE ===
    await page.goto('/login');
    await page.locator('input[name="email"]').fill('admin@gmail.com');
    await page.locator('input[name="password"]').fill('pass123');
    await page.getByRole('button', { name: 'Masuk Sekarang' }).click();

    // Admin diredirect ke admin dashboard
    await page.waitForURL(/\/admin\/dashboard/);

    // Buka halaman approval
    await page.goto('/admin/approval');
    await expect(page.getByRole('heading', { name: 'Persetujuan Kafe Usulan' })).toBeVisible();

    // Cari kafe yang baru diusulkan
    const searchInput = page.getByPlaceholder('Cari kafe atau pengusul...');
    await searchInput.fill(namaKafe);

    // Klik tombol Detail untuk membuka side panel
    const detailBtn = page.locator('td').filter({ hasText: 'Detail' }).getByRole('button').first();
    await detailBtn.click();

    // Verifikasi panel terbuka dan memuat data
    await expect(page.locator('#panel-content')).toBeVisible();
    
    // Klik tombol Terima
    const approveBtn = page.getByRole('button', { name: 'Terima' });
    await expect(approveBtn).toBeVisible();
    await approveBtn.click();

    // Pastikan status sukses muncul
    await expect(page.locator('text=Usulan kafe berhasil disetujui')).toBeVisible({ timeout: 10000 });

    // Logout admin
    const adminAvatar = page.locator('header').locator('button').filter({ has: page.locator('img') }).first();
    await adminAvatar.click();
    const adminDropdown = page.locator('div[x-show="open"]').first();
    await expect(adminDropdown).toBeVisible({ timeout: 5000 });
    const adminLogoutBtn = adminDropdown.locator('button:has-text("Keluar")');
    await adminLogoutBtn.click();
    await page.waitForURL('/');

    // === LANGKAH 3: VERIFIKASI KAFE MUNCUL DI EKSPLORASI ===
    await page.goto('/explore');
    const searchPublicInput = page.getByPlaceholder('Cari kafe, area, atau suasana...');
    await searchPublicInput.fill(namaKafe);
    
    // Verifikasi card/dropdown kafe baru tersebut kini tampil dan bisa diakses publik
    await expect(page.getByRole('heading', { name: namaKafe })).toBeVisible({ timeout: 15000 });
  });

});
