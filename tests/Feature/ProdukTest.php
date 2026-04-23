<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Produk;

class ProdukTest extends TestCase
{
    use RefreshDatabase;

    public function test_tambah_produk_berhasil()
    {
        $response = $this->post('/simpan-produk', [
            'nama_produk' => 'Oli Mesin',
            'harga_per_unit' => 75000,
            'jumlah' => 10,
        ]);

        $response->assertRedirect('/inventory');
        $response->assertSessionHas('success', 'Produk berhasil ditambahkan!');

        $this->assertDatabaseHas('produk', [ 
            'nama_produk' => 'Oli Mesin',
            'harga_per_unit' => 75000,
            'jumlah' => 10,
        ]);
    }
        public function test_tambah_produk_gagal_nama_kosong()
    {
        $response = $this->post('/simpan-produk', [
            'nama_produk' => '',
            'harga_per_unit' => 75000,
            'jumlah' => 10,
        ]);

        $response->assertSessionHasErrors('nama_produk');
    }

    public function test_tambah_produk_gagal_harga_bukan_angka()
    {
        $response = $this->post('/simpan-produk', [
            'nama_produk' => 'Oli Mesin',
            'harga_per_unit' => 'abc',
            'jumlah' => 10,
        ]);

        $response->assertSessionHasErrors('harga_per_unit');
    }

    public function test_tambah_produk_gagal_jumlah_bukan_integer()
    {
        $response = $this->post('/simpan-produk', [
            'nama_produk' => 'Oli Mesin',
            'harga_per_unit' => 75000,
            'jumlah' => 'sepuluh',
        ]);

        $response->assertSessionHasErrors('jumlah');
    }

    public function test_update_produk_berhasil()
    {
        // Buat produk awal dulu
        $produk = Produk::create([
            'nama_produk' => 'Oli Lama',
            'harga_per_unit' => 50000,
            'jumlah' => 5,
        ]);

        $response = $this->post('/update-produk/' . $produk->id, [
            'nama_produk' => 'Oli Baru',
            'harga_per_unit' => 75000,
            'jumlah' => 10,
        ]);

        $response->assertRedirect('/inventory');
        $response->assertSessionHas('success', 'Produk berhasil diperbarui');

        $this->assertDatabaseHas('produk', [ 
            'id' => $produk->id,
            'nama_produk' => 'Oli Baru',
            'harga_per_unit' => 75000,
            'jumlah' => 10,
        ]);
    }


    public function test_update_produk_gagal_nama_kosong()
    {
        $produk = Produk::create([
            'nama_produk' => 'Oli Lama',
            'harga_per_unit' => 50000,
            'jumlah' => 5,
        ]);

        $response = $this->post('/update-produk/' . $produk->id, [
            'nama_produk' => '',
            'harga_per_unit' => 75000,
            'jumlah' => 10,
        ]);

        $response->assertSessionHasErrors('nama_produk');
    }


    public function test_hapus_produk_berhasil()
    {
        // Buat produk dulu
        $produk = Produk::create([
            'nama_produk' => 'Oli Mesin',
            'harga_per_unit' => 75000,
            'jumlah' => 10,
        ]);

        $response = $this->get('/hapus-produk/' . $produk->id);

        $response->assertRedirect('/inventory');
        $response->assertSessionHas('success', 'Produk berhasil dihapus');

        $this->assertDatabaseMissing('produk', [ // ⚠ cek nama tabel kamu
            'id' => $produk->id,
        ]);
    }
}