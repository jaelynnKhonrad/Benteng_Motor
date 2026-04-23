<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Akun;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_berhasil()
    {
        $akun = Akun::create([
            'email' => 'natasha@gmail.com',
            'password' => Hash::make('123456')
        ]);

        $response = $this->post('/login', [
            'email' => 'natasha@gmail.com',
            'password' => '123456'
        ]);

        $response->assertRedirect('/dashboard');

        $response->assertSessionHas('email', 'natasha@gmail.com');
    }

    public function test_login_gagal()
    {
        $response = $this->post('/login', [
            'email' => 'salah@gmail.com',
            'password' => '123456'
        ]);

        $response->assertSessionHas('error');
    }
}