<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Akun;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Hash;

class IntegrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_alur_register_login_dashboard()
    {
        // Register
        $this->post('/register', [
            'email' => 'user@test.com',
            'password' => '123456'
        ]);

        // Login
        $response = $this->post('/login', [
            'email' => 'user@test.com',
            'password' => '123456'
        ]);

        // Akses dashboard
        $dashboard = $this->get('/dashboard');

        $response->assertRedirect('/dashboard');
        $dashboard->assertStatus(200);
    }

    public function test_tambah_produk_masuk_database()
    {
        $response = $this->post('/simpan-produk', [
            'nama_produk' => 'Oli',
            'harga_per_unit' => 50000,
            'jumlah' => 5
        ]);

        $response->assertRedirect('/inventory');

        $this->assertDatabaseHas('produk', [
            'nama_produk' => 'Oli'
        ]);
    }

    public function test_update_produk_terupdate_di_database()
    {
        $produk = Produk::create([
            'nama_produk' => 'Oli Lama',
            'harga_per_unit' => 40000,
            'jumlah' => 2
        ]);

        $this->post('/update-produk/' . $produk->id, [
            'nama_produk' => 'Oli Baru',
            'harga_per_unit' => 60000,
            'jumlah' => 10
        ]);

        $this->assertDatabaseHas('produk', [
            'id' => $produk->id,
            'nama_produk' => 'Oli Baru'
        ]);
    }

    public function test_tambah_transaksi_masuk_database()
    {
        $this->post('/simpan-transaksi', [
            'tanggal_transaksi' => '2025-01-01',
            'total_harga' => 100000,
            'pesan' => 'Test',
            'tipe' => 'pemasukan'
        ]);

        $this->assertDatabaseHas('pembukuan', [
            'pesan' => 'Test'
        ]);
    }

    public function test_hapus_transaksi_terhapus_dari_database()
    {
        $transaksi = Transaksi::create([
            'tanggal_transaksi' => '2025-01-01',
            'total_harga' => 100000,
            'pesan' => 'Hapus',
            'tipe' => 'pengeluaran'
        ]);

        $this->get('/hapus-transaksi/' . $transaksi->id);

        $this->assertDatabaseMissing('pembukuan', [
            'id' => $transaksi->id
        ]);
    }
}