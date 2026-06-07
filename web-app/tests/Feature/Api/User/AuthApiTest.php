<?php

namespace Tests\Feature\Api\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function mahasiswa_can_register_through_api(): void
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Afgan Galih',
            'email' => 'afgan@student.polinema.ac.id',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertCreated()
            ->assertJsonPath('success', true)
            ->assertJsonPath('user.role', 'mahasiswa')
            ->assertJsonStructure([
                'success',
                'message',
                'token',
                'user' => ['id', 'name', 'email', 'role'],
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'afgan@student.polinema.ac.id',
            'role' => 'mahasiswa',
        ]);

        $this->assertTrue(Hash::check(
            'password123',
            User::where('email', 'afgan@student.polinema.ac.id')->first()->password
        ));
    }

    /** @test */
    public function register_fails_when_email_is_duplicate(): void
    {
        User::factory()->create([
            'email' => 'afgan@student.polinema.ac.id',
            'role' => 'mahasiswa',
        ]);

        $response = $this->postJson('/api/register', [
            'name' => 'Afgan Galih',
            'email' => 'afgan@student.polinema.ac.id',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors('email');
    }

    /** @test */
    public function mahasiswa_can_login_and_access_me_endpoint(): void
    {
        $user = User::factory()->create([
            'email' => 'mahasiswa@student.polinema.ac.id',
            'password' => Hash::make('password123'),
            'role' => 'mahasiswa',
        ]);

        $login = $this->postJson('/api/login', [
            'email' => 'mahasiswa@student.polinema.ac.id',
            'password' => 'password123',
        ]);

        $login->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonStructure(['token']);

        $this->withHeader('Authorization', 'Bearer ' . $login->json('token'))
            ->getJson('/api/me')
            ->assertOk()
            ->assertJsonPath('user.id', $user->id)
            ->assertJsonPath('user.role', 'mahasiswa');
    }

    /** @test */
    public function admin_cannot_login_through_mahasiswa_api(): void
    {
        User::factory()->create([
            'email' => 'admin@ngafein.test',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'admin@ngafein.test',
            'password' => 'password123',
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors('email');
    }
}
