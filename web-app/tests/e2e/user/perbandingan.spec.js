// @ts-check
import { test, expect } from '@playwright/test';

test.describe('Fitur Perbandingan Kafe', () => {

  test.beforeEach(async ({ page }) => {
    // 1. Masuk ke halaman rekomendasi dan cari kafe terlebih dahulu agar daftarnya muncul
    await page.goto('/kafe/rekomendasi');
    await page.locator('select[name="harga_max"]').selectOption('999999');
    await page.locator('select[name="jarak_max"]').selectOption('999');
    await page.getByRole('button', { name: 'Cari Rekomendasi' }).click();

    // Pastikan hasil sudah muncul
    await expect(page.locator('#kafe-grid a').first()).toBeVisible();
  });

  test('Pengujian Negatif - Mencoba membandingkan kurang dari 2 kafe', async ({ page }) => {
    // 1. Pilih hanya 1 kafe untuk dibandingkan
    const firstCafeCompareBtn = page.locator('#kafe-grid a button').first();
    await firstCafeCompareBtn.click();

    // 2. Klik tombol "Bandingkan" pada floating bar
    const compareFloatingBtn = page.getByRole('button', { name: 'Bandingkan', exact: true });
    await expect(compareFloatingBtn).toBeVisible();
    await compareFloatingBtn.click();

    // 3. Verifikasi toast error muncul dengan pesan validasi
    const toastError = page.locator('text=Pilih minimal 2 kafe');
    await expect(toastError).toBeVisible();
  });

  test('Pengujian Positif - Membandingkan 2 kafe secara sukses', async ({ page }) => {
    // 1. Pilih kafe pertama
    const firstCafeCompareBtn = page.locator('#kafe-grid a button').nth(0);
    await firstCafeCompareBtn.click();

    // 2. Pilih kafe kedua
    const secondCafeCompareBtn = page.locator('#kafe-grid a button').nth(1);
    await secondCafeCompareBtn.click();

    // 3. Klik tombol "Bandingkan" pada floating tray
    const compareFloatingBtn = page.getByRole('button', { name: 'Bandingkan', exact: true });
    await expect(compareFloatingBtn).toBeVisible();
    await compareFloatingBtn.click();

    // 4. Verifikasi modal perbandingan muncul
    const modalHeader = page.getByRole('heading', { name: 'Analisis Komparatif' });
    await expect(modalHeader).toBeVisible();

    // 5. Pastikan tombol close modal berfungsi
    await page.locator('div[x-show="showModal"] .border-b button').click();
    await expect(modalHeader).not.toBeVisible();
  });

});
