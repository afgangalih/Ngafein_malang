// @ts-check
import { test, expect } from '@playwright/test';

test.describe('Fitur Usulan Kafe Baru', () => {

  test('Pengujian Negatif - Pengunjung anonim ditolak masuk halaman tambah kafe', async ({ page }) => {
    // 1. Coba paksa akses rute tambah kafe secara langsung
    await page.goto('/kafe/tambah');

    // 2. Karena dilindungi middleware auth, user diarahkan ke halaman login
    await expect(page).toHaveURL(/\/login/);
  });

  test('Pengujian Negatif - Validasi input form wajib diisi', async ({ page }) => {
    // 1. Login terlebih dahulu sebagai mahasiswa agar bisa masuk halaman tambah kafe
    await page.goto('/');
    await page.locator('nav').getByRole('button', { name: 'Masuk', exact: true }).click();
    
    const loginForm = page.locator('form').filter({ has: page.getByRole('button', { name: 'Masuk' }) });
    await loginForm.locator('input[type="email"]').fill('mahasiswa@gmail.com');
    await loginForm.locator('input[type="password"]').fill('pass123');
    await loginForm.getByRole('button', { name: 'Masuk' }).click();

    // Tunggu halaman reload/avatar profil muncul
    const avatarButton = page.locator('nav').locator('div.relative button').filter({ has: page.locator('svg') }).first();
    await expect(avatarButton).toBeVisible({ timeout: 10000 });

    // 2. Pergi ke halaman tambah kafe
    await page.goto('/kafe/tambah');
    await expect(page.getByRole('heading', { name: 'Usulkan Kafe Baru' })).toBeVisible();

    // 3. Kosongkan input nama kafe
    await page.locator('input[name="nama_kafe"]').fill('');

    // 4. Coba submit form
    await page.getByRole('button', { name: 'Kirim Usulan Kafe' }).click();

    // 5. Verifikasi error validasi AlpineJS muncul di layar
    const errorText = page.getByText('Nama kafe wajib diisi!', { exact: false });
    await expect(errorText).toBeVisible();
  });

  test('Pengujian Positif - Berhasil mengusulkan kafe baru', async ({ page }) => {
    // 1. Login sebagai mahasiswa
    await page.goto('/');
    await page.locator('nav').getByRole('button', { name: 'Masuk', exact: true }).click();
    
    const loginForm = page.locator('form').filter({ has: page.getByRole('button', { name: 'Masuk' }) });
    await loginForm.locator('input[type="email"]').fill('mahasiswa@gmail.com');
    await loginForm.locator('input[type="password"]').fill('pass123');
    await loginForm.getByRole('button', { name: 'Masuk' }).click();

    const avatarButton = page.locator('nav').locator('div.relative button').filter({ has: page.locator('svg') }).first();
    await expect(avatarButton).toBeVisible({ timeout: 10000 });

    // 2. Masuk ke halaman tambah kafe
    await page.goto('/kafe/tambah');

    // 3. Isi formulir dengan data valid
    const timestamp = Date.now();
    const namaKafe = `Kafe E2E Test ${timestamp}`;
    await page.locator('input[name="nama_kafe"]').fill(namaKafe);
    await page.locator('input[name="jarak"]').fill('2.5');
    await page.locator('input[name="rating"]').fill('4.2');
    await page.locator('input[name="jam_buka"]').fill('10:00');
    await page.locator('input[name="jam_tutup"]').fill('23:00');
    await page.locator('input[name="harga_min"]').fill('12000');
    await page.locator('input[name="harga_max"]').fill('40000');
    await page.locator('textarea[name="alamat"]').fill('Jl. Ketawang Gede No. 45, Malang');
    await page.locator('input[name="link_maps"]').fill('https://maps.google.com/?q=kafe-e2e-test');

    // Centang salah satu fasilitas
    const firstFasility = page.locator('input[name="fasilitas[]"]').first();
    await firstFasility.check();

    // 4. Kirim usulan
    await page.getByRole('button', { name: 'Kirim Usulan Kafe' }).click();

    // 5. Verifikasi dialihkan / muncul flash session success di halaman web
    const successAlert = page.locator('text=Berhasil!');
    await expect(successAlert).toBeVisible({ timeout: 10000 });
  });

});
