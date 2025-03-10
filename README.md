## Tentang Aplikasi E-Arsip

E-Arsip merupakan aplikasi yang dirancang untuk menyimpan atau mengarsipkan file-file pdf yang dikususkan untuk mengarsipkan file undangan dan sejenisnya. Sangat direkomendasikan penggunakan untuk bidang pengarsipan surat pada organisasi atau instansi. Aplikasi ini sangat mudah untuk digunakan dan diharapkan bisa digunakan untuk operator arsip disemua usia. Beberapa fitur yang tertanam :

- Fitur data penerima yang digunakan untuk merekap penerima surat atau dokumen.
- Fitur data pengirim yang digunakan untuk merekap pengirim surat atau dokumen.
- Fitur pencatatan atau pengarsipan surat masuk atau dokumen yang masuk.

## Sistem yang dibutuhkan untuk penginstalan

E-Arsip menggunakan teknologi Laravel versi 11 dan Filament versi 3. Untuk menginstallnya dibutuhkan :

- PHP versi 8.2 atau diatasnya
- Database MariaDB atau PostgreSQL sesuai selera
- Apache atau Nginx

### Langkah - Langkah Penginstalan

- Silahkan unduh atau clone aplikasi dari repositori ini.
- Buat database dengan nama persuratan atau semacamnya.
- Masuk ke direktori aplikasi menggunakan command prompt untuk Windows atau terminal untuk Linux dan Mac Os.
- Untuk Windows jalankan perintah : copy .env.example .env
- Untuk Linux dan Mac Os jalankan perintah : cp .env.example .env
- Berikutnya jalankan perintah berikut : composer install
- Setelah selesai, jalankan perintah berikutnya : php artisan key:generate
- Pastikan kalian membuka file .env yang berhasil dibuat dari langkah diatas dan atur databasenya supaya terkoneksi dengan database kalian.
- Setelah sudah dipastikan bisa terkoneksi dengan database kalian maka jalankan perintah berikut : php artisan migrate
- Jika langkah - langkah diatas berjalan dengan lancar tanpa ada error, maka aplikasi berhasil diisntall dan sudah siap untuk digunakan.
- Jalankan aplikasi dengan perintah berikut :  php artisan serve
- All done...!! Selamat menggunakan 🔥

## Regsitrasi admin

Jalankan perintah berikut untuk registrasi pengguna Admin : php artisan make:filament-user

# persuratan
