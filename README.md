# delinquent.id

![](./public/images/banner.png)

Sebuah platform forum modern dan interaktif yang dibangun dengan TALL stack (Tailwind, Alpine, Livewire, Laravel), dirancang untuk diskusi yang menarik dan interaksi komunitas yang dinamis.

## ✨ Fitur

-   **Manajemen Artikel:** Buat, lihat, dan kelola artikel dengan konten _rich text_, gambar, kategori, dan _tag_ melalui panel admin Filament.
-   **UI/UX Modern:** Desain yang bersih, responsif, dan intuitif dibangun dengan Tailwind CSS dan Alpine.js.
-   **Komponen Dinamis:** Pengalaman pengguna yang mulus dengan pembaruan _real-time_ yang didukung oleh Livewire.
-   **Sistem Thread & Komentar:** Buat, lihat, dan berpartisipasi dalam diskusi dengan balasan berjenjang (_nested replies_).
-   **Sistem Voting:** Lakukan _upvote/downvote_ pada _thread_ dan komentar secara efisien untuk menyorot konten yang berharga.
-   **Profil Pengguna & Sistem Mengikuti:** Tampilan profil publik yang kaya dengan informasi pengguna, daftar thread dan artikel, serta kemampuan untuk mengikuti/berhenti mengikuti pengguna lain dengan pembaruan jumlah pengikut secara _real-time_.
-   **Kontrol Akses Berbasis Peran (RBAC):** Pemisahan hak akses yang jelas antara peran 'admin' dan 'member' menggunakan `spatie/laravel-permission`.
-   **Soft Deletes:** _Thread_ dan komentar dihapus secara _soft-delete_ untuk menjaga integritas data.
-   **Organisasi Kategori:** Jelajahi _thread_ berdasarkan kategori untuk navigasi yang mudah.
-   **Panel Admin (Filament):** Panel admin yang andal dan intuitif untuk mengelola pengguna, _thread_, kategori, dan lainnya.
-   **Seeder Idempoten:** _Database seeder_ dirancang agar dapat dijalankan berulang kali tanpa membuat data duplikat.

## 🚀 Teknologi yang Digunakan

-   **Laravel 11.x:** Kerangka kerja PHP untuk para pengrajin web.
-   **Livewire 3.x:** Kerangka kerja _full-stack_ untuk Laravel yang membuat pembuatan antarmuka dinamis menjadi sederhana.
-   **Tailwind CSS:** Kerangka kerja CSS _utility-first_ untuk membangun desain kustom dengan cepat.
-   **Alpine.js:** Kerangka kerja JavaScript minimalis untuk menyusun fungsionalitas langsung di dalam markup Anda.
-   **MySQL:** Manajemen database yang tangguh dan andal.
-   **Filament 3.x:** Kumpulan perangkat untuk membangun aplikasi TALL stack yang indah dengan cepat.
-   **Spatie Laravel Permission:** Untuk manajemen peran dan hak akses yang solid.
-   **Spatie Laravel Tags:** Untuk menambahkan dan mengelola _tag_ pada model.

## 📦 Instalasi

Ikuti langkah-langkah ini untuk menjalankan proyek di mesin lokal Anda.

### Prasyarat

-   PHP \>= 8.2
-   Composer
-   Node.js & npm (atau Yarn)
-   MySQL (atau database lain yang didukung oleh Laravel)

### Langkah-langkah

1.  **Clone repositori:**

    ```bash
    git clone https://github.com/Fadhilmagass/projek-delinquent.git
    cd projek-delinquent
    ```

2.  **Instal dependensi PHP:**

    ```bash
    composer install
    ```

3.  **Instal dependensi Node.js:**

    ```bash
    npm install
    ```

4.  **Salin file environment:**

    ```bash
    copy .env.example .env
    ```

5.  **Buat kunci aplikasi:**

    ```bash
    php artisan key:generate
    ```

6.  **Konfigurasi database Anda:**
    Buka file `.env` dan perbarui kredensial database Anda:

    ```dotenv
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=delinquent_id
    DB_USERNAME=root
    DB_PASSWORD=
    ```

    _(**Catatan:** Isi `DB_USERNAME` dan `DB_PASSWORD` sesuai dengan konfigurasi database lokal Anda.)_

7.  **Jalankan migrasi dan seeder database:**

    ```bash
    php artisan migrate --seed
    ```

    Perintah ini akan menyiapkan skema database dan mengisinya dengan data awal, termasuk peran, hak akses, dan pengguna admin default. _Seeder_ ini bersifat idempoten, artinya Anda dapat menjalankan perintah ini lagi tanpa menyebabkan kesalahan atau duplikasi data.

8.  **Tautkan penyimpanan (storage):**

    ```bash
    php artisan storage:link
    ```

9.  **Kompilasi aset:**

    ```bash
    npm run build && npm run dev
    ```

    Untuk lingkungan produksi, gunakan `npm run build`.

10. **Jalankan server pengembangan:**

    ```bash
    php artisan serve
    ```

    Aplikasi akan tersedia di `http://127.0.0.1:8000`.

## 💡 Pengguna Default

_Seeder_ database akan membuat pengguna default untuk tujuan pengujian dan administrasi. Untuk melihat dan mengatur kredensial (email & password) yang dibuat, silakan periksa file seeder yang bersangkutan (contoh: `database/seeders/UserSeeder.php`).

Anda dapat mengakses panel admin Filament di `/admin` menggunakan kredensial admin yang telah Anda tetapkan di dalam seeder.

## 🤝 Berkontribusi

Kontribusi sangat kami harapkan\! Jangan ragu untuk mengirimkan _pull request_.

1.  Lakukan _Fork_ pada Proyek
2.  Buat _Branch_ Fitur Anda (`git checkout -b feature/FiturLuarBiasa`)
3.  _Commit_ Perubahan Anda (`git commit -m 'Menambahkan FiturLuarBiasa'`)
4.  _Push_ ke _Branch_ (`git push origin feature/FiturLuarBiasa`)
5.  Buka sebuah _Pull Request_

## 📄 Lisensi

Proyek ini adalah perangkat lunak sumber terbuka yang dilisensikan di bawah [Lisensi MIT](https://opensource.org/licenses/MIT).
