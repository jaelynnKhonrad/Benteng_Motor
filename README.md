# Benteng Motor

## Deskripsi Aplikasi
Benteng Motor adalah aplikasi berbasis web yang digunakan untuk mengelola:
- Data produk (inventory)
- Transaksi pemasukan dan pengeluaran
- Autentikasi pengguna (login & register)

Aplikasi ini dibangun menggunakan Laravel dan dilengkapi dengan pengujian otomatis (unit test dan integration test).

---

## Fitur Utama
- Register & Login pengguna
- Manajemen produk (tambah, edit, hapus, lihat)
- Manajemen transaksi (pemasukan & pengeluaran)
- Perhitungan total pemasukan dan pengeluaran
- Sistem session untuk autentikasi

---

## Teknologi yang Digunakan
- PHP (Laravel Framework)
- MySQL / SQLite (untuk testing)
- PHPUnit (Testing)
- Xdebug (Code Coverage)

---

## Cara Menjalankan Aplikasi

1. Clone repository:
```bash
git clone https://github.com/USERNAME/REPO.git
cd REPO
```

2. Install Dependency:
```bash
composer install
```

3. Copy file environment: 
```bash
cp .env.example .env
```

4. Generate application key: 
```bash
php artisan key:generate
```
5. Atur Database di file .env
6. Jalankan migrasi: 
```bash 
php artisan migrate
```

7. Jalankan aplikasi:
```bash 
php artisan serve
```

## Cara menjalankan Testing 
Menjalankan semua test: 
```bash 
php artisan test
```
Menjalankan test dengan coverage: 
```bash 
php artisan test --coverage
```

## Strategi Pengujian 
# Unit Testing 
Digunakan untuk menguji:
- Validasi input (produk & transaksi)
- Logika dasar aplikasi 
Total: minimal 15 test case 

# Integration Testing 
Digunakan untuk menguji:
- Endpoint (request ke controller)
- Interaksi dengan database 
- Alur autentikasi (register → login → dashboard)
- CRUD produk dan transaksi 
Total: minimal 5 integration test

## Test Coverage 
Hasil coverage: 
Total: 73.5%
Coverage telah memenuhi target minimal (60%)

## Continuos Integration 
Project ini menggunakan GitHub Actions untuk:
- Build aplikasi
- Install dependency
- Menjalankan test otomatis
- Menghasilkan laporan coverage

Workflow berjalan saat:
- Push
- Pull Request

## Struktur Folder 
app/
tests/
routes/
resources/
database/
.github/workflows/

## Catatan
Beberapa warning "deprecated" muncul karena versi PHP terbaru (8.5), namun tidak mempengaruhi jalannya aplikasi maupun testing.
