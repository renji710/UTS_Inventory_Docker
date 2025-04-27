# Proyek UTS - Backend Sistem Manajemen Inventory (Laravel + Filament + Docker)

Proyek ini adalah implementasi backend untuk sistem manajemen inventaris toko sederhana, dibuat sebagai bagian dari Ujian Tengah Semester (UTS) mata kuliah Backend Programming. Aplikasi ini dibangun menggunakan framework Laravel, dengan panel admin interaktif menggunakan Filament, dan dijalankan dalam lingkungan tercontainerisasi menggunakan Docker.

## Deskripsi Proyek

Aplikasi backend ini memungkinkan pengelolaan data inti inventaris, termasuk:
*   **Items (Barang):** Detail barang, harga, kuantitas, kategori, dan pemasok.
*   **Categories (Kategori):** Pengelompokan barang.
*   **Suppliers (Pemasok):** Informasi pemasok barang.
*   **Admins (Pengguna):** Pengguna yang dapat mengelola data melalui panel admin.

Setiap perubahan data (pembuatan item, kategori, supplier) dicatat berdasarkan admin yang bertanggung jawab (`created_by`).

## Developer

Raditya Abdul Afeef

A11.2022.14203

## Fitur Utama

*   **Panel Admin (Filament):** Antarmuka web untuk operasi CRUD (Create, Read, Update, Delete) pada Items, Categories, Suppliers, dan Admins.
*   **Dashboard Widget:**
    *   **Statistik Overview:** Menampilkan ringkasan total unit item, total nilai stok, rata-rata harga item, jumlah kategori, jumlah supplier, dan jumlah jenis item.
    *   **Low Stock Items:** Menampilkan daftar item dengan stok di bawah batas tertentu (default: 5 unit) dalam bentuk tabel yang bisa di-scroll.
    *   **Category Summary:** Menampilkan ringkasan jumlah jenis item, total nilai stok, dan rata-rata harga per kategori dalam bentuk tabel yang bisa di-scroll.
    *   **Supplier Summary:** Menampilkan ringkasan jumlah jenis item yang disuplai dan total nilai barang per pemasok dalam bentuk tabel yang bisa di-scroll.
*   **Dockerized Environment:** Aplikasi, web server (Nginx), dan database (MySQL) berjalan dalam container Docker yang terisolasi dan konsisten.
*   **Database Seeding:** Menyediakan data awal untuk kategori, supplier, dan item bertema komputer.
*   **Struktur Proyek Terpisah:** Konfigurasi Docker dipisahkan dari kode sumber aplikasi Laravel (`src/`).

## Teknologi yang Digunakan

*   PHP 8.2
*   Laravel Framework 10.x
*   Filament 3.x
*   MySQL 8.0
*   Nginx (sebagai web server di Docker)
*   Docker & Docker Compose

## Prasyarat

Sebelum menjalankan proyek ini, pastikan app berikut sudah terinstal:
*   **Docker Desktop** (Windows/Mac) atau **Docker Engine + Docker Compose CLI** (Linux).
*   **Git** (untuk mengkloning repositori).


## Instalasi dan Setup

1.  **Kloning Repositori:**
    ```bash
    git clone https://github.com/renji710/UTS_Inventory_Docker.git UTS_Inventory_Repo
    cd UTS_Inventory_Repo
    ```

2.  **Konfigurasi Environment Laravel:**
    *   Salin file konfigurasi contoh di dalam direktori `src/`:
        ```bash
        # Di Windows (Command Prompt)
        copy src\.env.example src\.env

        # Di Windows (Git Bash / PowerShell) atau Linux/MacOS
        cp src/.env.example src/.env
        ```
    *   **PENTING:** Buka file `src/.env`. Pastikan variabel database **sesuai** dengan yang ada di `docker-compose.yml`:
        *   `DB_CONNECTION=mysql`
        *   `DB_HOST=db` (nama service database di `docker-compose.yml`)
        *   `DB_PORT=3306`
        *   `DB_DATABASE=inventory_uts` (sama dengan `MYSQL_DATABASE` di `docker-compose.yml`)
        *   `DB_USERNAME=root` (sesuai dengan user yang di set di `docker-compose.yml`)
        *   `DB_PASSWORD=12345` ( sama dengan `MYSQL_ROOT_PASSWORD` atau `MYSQL_PASSWORD` di `docker-compose.yml`)

3.  **Konfigurasi Password Database di Docker Compose:**
    *   Buka file `docker-compose.yml`.
    *   Cari bagian `environment` di bawah service `db`.
    *   Ubah nilai `MYSQL_ROOT_PASSWORD` (atau `MYSQL_PASSWORD` jika menggunakan user custom) menjadi password yang aman dan **pastikan sama** dengan `DB_PASSWORD` di `src/.env`.

4.  **Build dan Jalankan Container:**
    *   Dari direktori root repositori (`UTS_Inventory_Repo`), jalankan perintah berikut:
        ```bash
        docker compose up --build -d
        ```
    *   Perintah ini akan membangun image aplikasi (jika belum ada atau jika `Dockerfile` berubah) dan menjalankan semua container (app, web, db) di background. Proses build pertama kali mungkin memakan waktu beberapa menit.

5.  **Generate Laravel Application Key:**
    *   Setelah container berjalan (tunggu beberapa saat setelah `up`), jalankan perintah ini untuk men-generate kunci aplikasi Laravel:
        ```bash
        docker compose exec app php artisan key:generate
        ```

6.  **Jalankan Migrasi dan Seeding Database:**
    *   Jalankan perintah ini untuk membuat struktur tabel database dan mengisi data awal:
        ```bash
        docker compose exec app php artisan migrate:fresh --seed
        ```

## Menjalankan Aplikasi

*   **Mulai:** `docker compose up -d` (dari root repositori)
*   **Hentikan:** `docker compose down`
*   **Hentikan & Hapus Volume DB:** `docker compose down -v`

## Mengakses Aplikasi

*   **URL Aplikasi / Panel Admin:** Buka browser dan akses `http://localhost:8000/admin` (port 8000 sesuai mapping di `docker-compose.yml`).
*   **Login Default:**
    *   Email: `admin1@gmail.com`
    *   Password: `12345` (sesuai di `AdminUserSeeder.php`).
*   **Loading akan memakan cukup waktu, harap bersabar**

## Catatan Implementasi Tugas

Sesuai deskripsi proyek UTS, aplikasi ini mencakup:
*   Pengelolaan data Item, Category, Supplier, dan Admin.
*   Penggunaan framework Laravel dan database relasional (MySQL).
*   Pencatatan `created_by` untuk data utama.
*   Containerisasi menggunakan Docker (`Dockerfile` dan `docker-compose.yml`).
*   Implementasi operasi basis data yang diminta. Tugas berikut telah diimplementasikan:
    *   **CRUD Item, Category, Supplier:** Disediakan melalui Filament Resources.
    *   **Ringkasan Stok, Nilai Stok, Rata-rata Harga, Jumlah Kategori/Supplier:** Diimplementasikan sebagai **Widget Statistik** di Dashboard Filament.
    *   **Daftar Barang Stok Rendah:** Diimplementasikan sebagai **Widget Tabel** di Dashboard Filament.
    *   **Ringkasan per Kategori:** Diimplementasikan sebagai **Widget Tabel** di Dashboard Filament.
    *   **Ringkasan per Pemasok:** Diimplementasikan sebagai **Widget Tabel** di Dashboard Filament.
