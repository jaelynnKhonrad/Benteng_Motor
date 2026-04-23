<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Transaksi;

class TransaksiTest extends TestCase
{
    use RefreshDatabase;

    public function test_tambah_transaksi_berhasil()
    {
        $response = $this->post('/simpan-transaksi', [
            'tanggal_transaksi' => '2025-01-01',
            'total_harga' => 500000,
            'pesan' => 'Pembelian barang',
            'tipe' => 'pengeluaran'
        ]);

        $response->assertRedirect('/transaksi');
        $response->assertSessionHas('success', 'Transaksi berhasil ditambahkan!');

        $this->assertDatabaseHas('pembukuan', [
            'tanggal_transaksi' => '2025-01-01',
            'total_harga' => 500000,
            'pesan' => 'Pembelian barang',
            'tipe' => 'pengeluaran'
        ]);
    }

    public function test_update_transaksi_berhasil()
    {
        $transaksi = Transaksi::create([
            'tanggal_transaksi' => '2025-01-01',
            'total_harga' => 500000,
            'pesan' => 'Pembelian barang',
            'tipe' => 'pengeluaran'
        ]);

        $response = $this->post('/update-transaksi/' . $transaksi->id, [
            'tanggal_transaksi' => '2025-02-01',
            'total_harga' => 750000,
            'pesan' => 'Update transaksi',
            'tipe' => 'pemasukan'
        ]);

        $response->assertRedirect('/transaksi');
        $response->assertSessionHas('success', 'Transaksi diupdate');

        $this->assertDatabaseHas('pembukuan', [
            'id' => $transaksi->id,
            'tanggal_transaksi' => '2025-02-01',
            'total_harga' => 750000,
            'pesan' => 'Update transaksi',
            'tipe' => 'pemasukan'
        ]);
    }

    public function test_hapus_transaksi_berhasil()
    {
        $transaksi = Transaksi::create([
            'tanggal_transaksi' => '2025-01-01',
            'total_harga' => 500000,
            'pesan' => 'Pembelian barang',
            'tipe' => 'pengeluaran'
        ]);

        $response = $this->get('/hapus-transaksi/' . $transaksi->id);

        $response->assertRedirect('/transaksi');
        $response->assertSessionHas('success', 'Transaksi dihapus');

        $this->assertDatabaseMissing('pembukuan', [
            'id' => $transaksi->id
        ]);
    }
}
