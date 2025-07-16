# 🏷️ Website Inspeksi Alat Berat

**Website untuk pencatatan dan pelaporan inspeksi alat berat**  
Website Inspeksi Alat Berat adalah aplikasi untuk melakukan inspeksi kelayakan alat berat secara digital.

## ✨ Fitur

-   🧑‍💼 Multi-role Login (Admin, Inspector, Customer)
-   👤 Manajemen Pengguna (CRUD User)
-   🚜 Manajemen Alat Berat (CRUD Heavy Equipment)
-   📋 Manajemen Inspeksi (CRUD Inspection)
-   ✅ Form Inspeksi Dinamis berdasarkan jenis unit alat berat
-   📸 Upload Foto kondisi unit & kerusakan
-   📝 Checklist & Catatan Kondisi selama inspeksi
-   📤 Export Laporan Inspeksi ke format PDF dan Excel

## ⚙️ Teknologi

-   Laravel 12
-   PHP 8.3
-   Tailwind CSS
-   Alpine.js
-   MySQL
-   Bootstrap Icon
-   DOMPDF
-   MaatWebsite/Excel

## 🛠️ Instalasi & Setup

1. Clone repository:

    ```bash
    git clone https://github.com/theowongkar/inspeksi-alat-berat.git
    cd inspeksi-alat-berat
    ```

2. Install dependency:

    ```bash
    composer install
    npm install && npm run build
    ```

3. Salin file `.env`:

    ```bash
    cp .env.example .env
    ```

4. Atur konfigurasi `.env` (database, mail, dsb)

5. Generate key dan migrasi database:

    ```bash
    php artisan key:generate
    php artisan storage:link
    php artisan migrate:fresh --seed
    ```

6. Jalankan server lokal:

    ```bash
    php artisan serve
    ```

7. Buka browser dan akses http://127.0.0.1:8000

## 👥 Role & Akses

| Role      | Akses                                       |
| --------- | ------------------------------------------- |
| Admin     | CRUD data user, heavy equipment, inspection |
| Inspector | CR data inspeksi                            |
| Customer  | R data inspeksi                             |

## 📎 Catatan Tambahan

-   Pastikan folder `storage` dan `bootstrap/cache` writable.
-   Dapat dikembangkan lebih lanjut untuk integrasi API unit tracking (GPS, IoT, dsb)
