## Tentang Aplikasi E-Arsip

E-Arsip merupakan aplikasi yang dirancang untuk menyimpan atau mengarsipkan file-file pdf yang dikususkan untuk mengarsipkan file undangan dan sejenisnya. Sangat direkomendasikan penggunakan untuk bidang pengarsipan surat pada organisasi atau instansi. Aplikasi ini sangat mudah untuk digunakan dan diharapkan bisa digunakan untuk operator arsip disemua usia. Beberapa fitur yang tertanam :

- Fitur data penerima yang digunakan untuk merekap penerima surat atau dokumen.
- Fitur data pengirim yang digunakan untuk merekap pengirim surat atau dokumen.
- Fitur pencatatan atau pengarsipan surat masuk atau dokumen yang masuk.
- Fitur backup data 🚀.
- Fitur pencatatan atau pengarsipan surat keluar atau dokumen yang keluar.
- Firut soft delete yang berguna untuk membantu anda jika terjadi hapus data yang tidak disengaja sehingga data bisa dikembalikan 🚀.
- Fitur generate QRCode untuk surat keluar yang akan dibubuhkan pada berkas surat keluar ber-TTE 🚀.
- Fitur update aplikasi secara manual pada halaman pengaturan 🚀.
- Aplikasi sekarang bisa berjalan ke dalam lingkungan docker 🚀.

## Sistem yang dibutuhkan untuk penginstalan

E-Arsip menggunakan teknologi Laravel versi 11 dan Filament versi 3. Untuk menginstallnya dibutuhkan :

- PHP versi 8.2 atau diatasnya
- Database MariaDB atau PostgreSQL sesuai selera
- Apache atau Nginx

### Langkah - Langkah Penginstalan

- Silahkan unduh atau clone aplikasi dari repositori ini.
- Buat database dengan nama persuratan atau semacamnya.
- Masuk ke direktori aplikasi menggunakan command prompt untuk Windows atau terminal untuk Linux dan Mac Os.
- Untuk Windows jalankan perintah : ```copy .env.example .env```
- Untuk Linux dan Mac Os jalankan perintah : ```cp .env.example .env```
- Berikutnya jalankan perintah berikut : ```composer install```
- Setelah selesai, jalankan perintah berikutnya : ```php artisan key:generate```
- Pastikan kalian membuka file .env yang berhasil dibuat dari langkah diatas dan atur databasenya supaya terkoneksi dengan database kalian.
- Setelah sudah dipastikan bisa terkoneksi dengan database kalian maka jalankan perintah berikut : ```php artisan migrate```
- Jika langkah - langkah diatas berjalan dengan lancar tanpa ada error, maka aplikasi berhasil diisntall dan sudah siap untuk digunakan.
- Jalankan aplikasi dengan perintah berikut :  ```php artisan serve```
- All done...!! Selamat menggunakan 🔥

## Regsitrasi admin

Jalankan perintah berikut untuk registrasi pengguna Admin : ```php artisan make:filament-user```

### Langkah - Langkah Penginstalan Untuk Lingkungan Docker

Hore... 🎉 !!!  
Sekarang kalian bisa jalankan aplikasi ini pada lingkungan docker lo. Cara installnya sebagai berkut :

- Silahkan melakukan update dulu dari aplikasi lama menggunakan tombol update aplikasi pada halaman pengaturan.
- Jika kalian pengguna baru silahkan jalankan dulu langkah penginstalan diatas sampai membuat file ```.env```. 
- Update composernya dulu dengan : ```composer update```. 
- Selanjutnya jalankan perintah berikut pada terminal atau command prompt kalian :  ```php artisan sail:install --with=pgsql```
- Selanjutnya jalankan dengan perintah berikut : ```./vendor/bin/sail up -d```
- Mungkin proses diatas sedikit lama tergantung internet kalian.
- Bila sudah selesai jalankan generate key dengan perintah berikut : ```./vendor/bin/sail artisan key:generate```
- Dan migrate databasenye : ```./vendor/bin/sail artisan migrate```

* Sedikit catatan :
Lakukan port forwarding agar port yang berjalan tidak terjadi crash atau error saat dijalankan. Pada file .env lakukan konfigurasi seperti berikut :

```env
DB_CONNECTION=pgsql  
DB_HOST=pgsql  
FORWARD_DB_PORT=5433  
DB_PORT=5432  
DB_DATABASE=laravel  
DB_USERNAME=sail  
DB_PASSWORD=password  
```

Dimana ```FORWARD_DB_PORT=5433``` digunakan untuk ekspos port database yang digunakan agar tidak crash dengan port database yang sudah berjalan pada komputer host.
Tambahkan juga ini pada .env untuk ekspos port aplikasi.
```APP_PORT=8080```

# persuratan
