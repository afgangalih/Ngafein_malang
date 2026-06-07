// @ts-check
import { test, expect } from '@playwright/test';

test.describe('Fitur Ulasan dan Bookmark Kafe', () => {

  test('Pengujian Negatif - Pengunjung anonim ditolak masuk halaman favorit', async ({ page }) => {
    // 1. Coba paksa akses rute favorit secara langsung
    await page.goto('/favorit');

    // 2. Karena dilindungi middleware auth, user harus diarahkan ke halaman login
    await expect(page).toHaveURL(/\/login/);
  });

  test('Pengujian Negatif - Validasi input ulasan wajib diisi (minimal 5 karakter)', async ({ page }) => {
    // 1. Login sebagai mahasiswa
    await page.goto('/');
    await page.locator('nav').getByRole('button', { name: 'Masuk', exact: true }).click();
    
    const loginForm = page.locator('form').filter({ has: page.getByRole('button', { name: 'Masuk' }) });
    await loginForm.locator('input[type="email"]').fill('mahasiswa@gmail.com');
    await loginForm.locator('input[type="password"]').fill('pass123');
    await loginForm.getByRole('button', { name: 'Masuk' }).click();

    // Tunggu login berhasil
    const avatarButton = page.locator('nav').locator('div.relative button').filter({ has: page.locator('svg') }).first();
    await expect(avatarButton).toBeVisible({ timeout: 10000 });

    // 2. Pergi ke detail kafe pertama
    await page.goto('/explore/1');

    // 3. Cari textarea ulasan dan kosongkan/ketik kurang dari 5 karakter
    const textarea = page.locator('textarea[name="ulasan"]');
    await expect(textarea).toBeVisible();
    await textarea.fill('abc'); // Kurang dari 5 karakter

    // 4. Klik kirim ulasan
    await page.getByRole('button', { name: 'Kirim Ulasan' }).click();

    // 5. Verifikasi error AlpineJS muncul
    const errorText = page.getByText('Isi ulasan minimal 5 karakter!', { exact: false });
    await expect(errorText).toBeVisible();
  });

  test('Pengujian Positif - Sukses bookmark & memberi ulasan di kafe', async ({ page }) => {
    // 1. Registrasi user baru untuk menjamin state bookmark bersih (clean slate)
    await page.goto('/');
    await page.locator('nav').getByRole('button', { name: 'Masuk', exact: true }).click();
    await page.getByRole('button', { name: 'Daftar Sekarang' }).click();

    const timestamp = Date.now();
    const uniqueEmail = `user_bookmark_${timestamp}@gmail.com`;

    const registerForm = page.locator('form').filter({ has: page.getByRole('button', { name: 'Daftar Sekarang' }) });
    await registerForm.locator('input[placeholder*="nama lengkap"]').fill(`Tester Bookmark ${timestamp}`);
    await registerForm.locator('input[type="email"]').fill(uniqueEmail);
    await registerForm.locator('input[placeholder="••••••••"]').first().fill('password123');
    await registerForm.locator('input[placeholder="••••••••"]').last().fill('password123');
    await registerForm.getByRole('button', { name: 'Daftar Sekarang' }).click();

    // Tunggu register & auto login selesai
    // 2. Pergi ke halaman detail kafe 1
    await page.goto('/explore/1');
    const cafeName = await page.locator('h1').innerText();

    // 3. Lakukan Bookmark (Simpan ke Favorit) - Karena user baru, pasti belum di-bookmark
    const bookmarkBtn = page.getByTitle('Simpan ke Favorit').first();
    await expect(bookmarkBtn).toBeVisible();
    await bookmarkBtn.click();
    await page.waitForTimeout(1000);

    // 4. Berikan ulasan valid
    const reviewText = `Ulasan E2E Test pada ${timestamp} - Tempatnya sangat nyaman, cocok untuk tugas kuliah!`;
    await page.locator('textarea[name="ulasan"]').fill(reviewText);
    await page.getByRole('button', { name: 'Kirim Ulasan' }).click();

    // 5. Verifikasi ulasan baru masuk dan terlihat di halaman
    await expect(page.getByText(reviewText)).toBeVisible({ timeout: 10000 });

    // 6. Pergi ke halaman Favorit untuk memastikan kafe terdaftar di sana
    await page.goto('/favorit');
    await expect(page.locator('h3').filter({ hasText: cafeName }).first()).toBeVisible({ timeout: 10000 });
  });

});
