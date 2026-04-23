<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Akun;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_berhasil()
    {
        $response = $this->post('/register', [
            'email' => 'natasha@gmail.com',
            'password' => '123456'
        ]);

        $response->assertRedirect('/');
        $response->assertSessionHas('success', 'Register berhasil');

        $this->assertDatabaseHas('akun', [
            'email' => 'natasha@gmail.com'
        ]);
    }

    public function test_register_gagal_email_kosong()
    {
        $response = $this->post('/register', [
            'email' => '',
            'password' => '123456'
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_register_gagal_password_kurang_dari_5()
    {
        $response = $this->post('/register', [
            'email' => 'natasha@gmail.com',
            'password' => '123'
        ]);

        $response->assertSessionHasErrors('password');
    }
}