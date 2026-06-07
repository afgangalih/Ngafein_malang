// @ts-check
import { test, expect } from '@playwright/test';

test.describe('Fitur Rekomendasi Kafe (SAW)', () => {

  test.beforeEach(async ({ page }) => {
    // Membuka halaman rekomendasi sebelum setiap pengujian
    await page.goto('/kafe/rekomendasi');
  });

  test('Tampilan Awal - Meminta user mengatur preferensi', async ({ page }) => {
    // Pengujian Awal sebelum melakukan pencarian
    const instructionText = page.getByText('Atur preferensimu dulu', { exact: false });
    await expect(instructionText).toBeVisible();

    // Memastikan list hasil rekomendasi belum dirender
    const resultsHeader = page.getByRole('heading', { name: 'Hasil Rekomendasi' });
    await expect(resultsHeader).not.toBeVisible();
  });

  test('Pengujian Negatif - Filter terlalu ketat menghasilkan halaman "Tidak ada cafe"', async ({ page }) => {
    // 1. Suntikkan opsi harga maksimal tidak valid (-1) ke select element via DOM
    await page.locator('select[name="harga_max"]').evaluate((select) => {
      const htmlSelect = /** @type {HTMLSelectElement} */ (select);
      const opt = document.createElement('option');
      opt.value = '-1';
      opt.text = 'Mustahil';
      htmlSelect.appendChild(opt);
    });
    
    // Pilih opsi tersebut menggunakan API Playwright
    await page.locator('select[name="harga_max"]').selectOption('-1');

    // Klik tombol Cari Rekomendasi
    await page.getByRole('button', { name: 'Cari Rekomendasi' }).click();

    // 2. Verifikasi sistem menampilkan layout error/no-data
    const noCafeText = page.getByText('Tidak ada cafe yang cocok', { exact: false });
    await expect(noCafeText).toBeVisible();

    // Pastikan tombol reset/coba lagi muncul
    const resetLink = page.locator('text=Reset & Coba Lagi');
    await expect(resetLink).toBeVisible();
  });

  test('Pengujian Positif - Pencarian dengan filter longgar berhasil menampilkan kafe', async ({ page }) => {
    // 1. Pilih filter yang lebih longgar/default
    await page.locator('select[name="harga_max"]').selectOption('999999'); // Semua harga / Mahal
    await page.locator('select[name="jarak_max"]').selectOption('999');    // Sangat Jauh > 6km

    // Klik Cari Rekomendasi
    await page.getByRole('button', { name: 'Cari Rekomendasi' }).click();

    // 2. Verifikasi Header "Hasil Rekomendasi" muncul
    const resultsHeader = page.getByRole('heading', { name: 'Hasil Rekomendasi' });
    await expect(resultsHeader).toBeVisible();

    // 3. Verifikasi minimal satu card kafe muncul di grid
    const cafeCard = page.locator('#kafe-grid a').first();
    await expect(cafeCard).toBeVisible();

    // 4. Verifikasi tombol Reset pencarian muncul di filter bar
    const resetBtn = page.locator('form').getByRole('link', { name: 'Reset' });
    await expect(resetBtn).toBeVisible();
  });

});
