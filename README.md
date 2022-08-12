PANDUAN INSTALASI

1. Copy .env.example menjadi .env

2. Setting informasi database .env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=notulen
   DB_USERNAME=root
   DB_PASSWORD=

3. Jika ingin terkoneksi dengan google drive pada .env lakukan setting yang dimiliki untuk terhubung ke google drive
   MAIL_MAILER=smtp
   MAIL_HOST=mailhog
   MAIL_PORT=1025
   MAIL_USERNAME=null
   MAIL_PASSWORD=null
   MAIL_ENCRYPTION=null
   MAIL_FROM_ADDRESS=null
   MAIL_FROM_NAME="${APP_NAME}"

4. Setelah .env siap, buka terminal dan masuk ke folder project ini dan lakukan perintah
   php artisan migrate:fresh --seed
   php artisan serve

5. Buka url http://127.0.0.1:8000 (default) setelah melakukan perintah diatas

6. Akses sebagai Admin user:admin password:admin
