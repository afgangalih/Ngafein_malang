// @ts-check
import { test, expect } from '@playwright/test';

test.describe('Autentikasi (Login, Register & Logout)', () => {

  // --- LOGIN TESTS ---

  test('Gagal login jika kredensial tidak sesuai', async ({ page }) => {
    await page.goto('/');

    const masukButton = page.locator('nav').getByRole('button', { name: 'Masuk', exact: true });
    await expect(masukButton).toBeVisible();
    await masukButton.click();

    const loginForm = page.locator('form').filter({ has: page.getByRole('button', { name: 'Masuk' }) });
    await loginForm.locator('input[type="email"]').fill('salah@gmail.com');
    await loginForm.locator('input[type="password"]').fill('passwordngasal');
    await loginForm.getByRole('button', { name: 'Masuk' }).click();

    const errorMessage = page.getByText('Email atau password yang Anda masukkan salah', { exact: false });
    await expect(errorMessage).toBeVisible();
  });

  test('Berhasil login menggunakan user Mahasiswa default', async ({ page }) => {
    await page.goto('/');
    await page.locator('nav').getByRole('button', { name: 'Masuk', exact: true }).click();

    const loginForm = page.locator('form').filter({ has: page.getByRole('button', { name: 'Masuk' }) });
    await loginForm.locator('input[type="email"]').fill('mahasiswa@gmail.com');
    await loginForm.locator('input[type="password"]').fill('pass123');
    await loginForm.getByRole('button', { name: 'Masuk' }).click();

    const avatarButton = page.locator('div.hidden.md\\:flex').getByRole('button').filter({ has: page.locator('circle') });
    await expect(avatarButton).toBeVisible({ timeout: 10000 });
    await avatarButton.click();

    const dropdownMenu = page.locator('div[x-show="open"]').first();
    await expect(dropdownMenu).toBeVisible({ timeout: 5000 });

    const logoutButton = dropdownMenu.locator('button:has-text("Keluar")');
    await logoutButton.click();
  });

  // --- REGISTER TESTS ---

  test('Gagal register jika email sudah terdaftar', async ({ page }) => {
    await page.goto('/');
    await page.locator('nav').getByRole('button', { name: 'Masuk', exact: true }).click();

    // Klik tombol 'Daftar Sekarang' di modal login untuk pindah ke modal register
    await page.getByRole('button', { name: 'Daftar Sekarang' }).click();

    const registerForm = page.locator('form').filter({ has: page.getByRole('button', { name: 'Daftar Sekarang' }) });
    await registerForm.locator('input[placeholder*="nama lengkap"]').fill('Tester Duplikat');
    await registerForm.locator('input[type="email"]').fill('mahasiswa@gmail.com'); // email yang sudah ada
    await registerForm.locator('input[placeholder="••••••••"]').first().fill('Password123');
    await registerForm.locator('input[placeholder="••••••••"]').last().fill('Password123');

    await registerForm.getByRole('button', { name: 'Daftar Sekarang' }).click();

    // Verifikasi error email unik muncul
    const emailError = page.getByText('Email ini sudah terdaftar di sistem', { exact: false });
    await expect(emailError).toBeVisible();
  });

  test('Gagal register jika konfirmasi password tidak cocok', async ({ page }) => {
    await page.goto('/');
    await page.locator('nav').getByRole('button', { name: 'Masuk', exact: true }).click();
    await page.getByRole('button', { name: 'Daftar Sekarang' }).click();

    const registerForm = page.locator('form').filter({ has: page.getByRole('button', { name: 'Daftar Sekarang' }) });
    await registerForm.locator('input[placeholder*="nama lengkap"]').fill('Tester Mismatch');
    await registerForm.locator('input[type="email"]').fill('mismatch@gmail.com');
    await registerForm.locator('input[placeholder="••••••••"]').first().fill('Password123');
    await registerForm.locator('input[placeholder="••••••••"]').last().fill('Berbeda123'); // password konfirmasi beda

    await registerForm.getByRole('button', { name: 'Daftar Sekarang' }).click();

    // Verifikasi error konfirmasi password muncul
    const confirmError = page.getByText('Konfirmasi password tidak cocok', { exact: false });
    await expect(confirmError).toBeVisible();
  });

  test('Berhasil register dengan data baru (Happy Path)', async ({ page }) => {
    await page.goto('/');
    await page.locator('nav').getByRole('button', { name: 'Masuk', exact: true }).click();
    await page.getByRole('button', { name: 'Daftar Sekarang' }).click();

    const timestamp = Date.now();
    const uniqueEmail = `user_${timestamp}@gmail.com`;

    const registerForm = page.locator('form').filter({ has: page.getByRole('button', { name: 'Daftar Sekarang' }) });
    await registerForm.locator('input[placeholder*="nama lengkap"]').fill(`Tester Baru ${timestamp}`);
    await registerForm.locator('input[type="email"]').fill(uniqueEmail);
    await registerForm.locator('input[placeholder="••••••••"]').first().fill('Password123');
    await registerForm.locator('input[placeholder="••••••••"]').last().fill('Password123');

    await registerForm.getByRole('button', { name: 'Daftar Sekarang' }).click();

    // Verifikasi otomatis login & reload ke homepage dengan ditandai munculnya tombol avatar user
    const avatarButton = page.locator('div.hidden.md\\:flex').getByRole('button').filter({ has: page.locator('circle') });
    await expect(avatarButton).toBeVisible({ timeout: 10000 });
  });

});
