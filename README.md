## Installation Laravel

Cara Installasi Apikasi CDC Laravel Project

- Pastikan Install [Composer](https://getcomposer.org/).


- git clone https://github.com/suhendar99/CDC-Project.git.
- Pastikan masuk Ke folder Apache nya.
- Jika sudah di clone msuk te commandprompt(CMD) alau arahkan directory nya ke dalam folder laravelnya.
- composer install.
- php artisan key:generate.
- copy dan paste .env.example dan rename dengan nama .env lalu atur DB nya.
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nama_database_anda
    DB_USERNAME=username_database_anda
    DB_PASSWORD=password_database_anda
- jika sudah kembali ke CMD dengan mengetik php artisan migrate --seed.
- ketik di cmd php artisan serve
- Buka di web browser http://localhost:8000 or http://127.0.0.1:8000

Terima Kasih....
