# Mydnex Blog
Create your first blog in php.

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/e1094b082b3a4cca9845cb55c658739d)](https://www.codacy.com/gh/PavelKlimovich/mydnex_blog/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=PavelKlimovich/mydnex_blog&amp;utm_campaign=Badge_Grade)



## Installation
<br>

#### PHP server on local machine
*********************************
1) Clone the project `git clone https://github.com/PavelKlimovich/mydnex_blog.git`.
2) In terminal change current working directory root `cd path/to/your/app` and execute  `php -S localhost:8000 -t public/` to throwing php server.
4) Install composer with `composer install & composer dump-autoload` .
5) Install npm with `npm install & npm run dev` .
6) Copy in the root of the project a new file `.env` from `.env.example` with 

    ```
    APP_NAME=mydnex_blog
    APP_URL=http://localhost

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=
    DB_USERNAME=
    DB_PASSWORD=

    EMAIL_FROM=
    ```

7) Execute : `php kernel migrate` to init DATABASE.
8) If you want generate fake data in database execute : `php kernel seed`.
    ```
    Admin : admin@mydnex.com
    Password : password
    ```

<br>

#### Apache Localhost Server ( Wamp, Xampp, Mamp or Laragon)
*********************************

1) Clone the project `git clone https://github.com/PavelKlimovich/mydnex_blog.git`.
2) Move the project to `/var/www/html`.
3) Change the root directory to `DocumentRoot /path/to_my_project/public` folder.
4) Install composer with `composer install & composer dump-autoload` .
5) Install npm with `npm install & npm run dev` .
6) Copy in the root of the project a new file `.env` from `.env.example` with 

    ```
    APP_NAME=mydnex_blog
    APP_URL=http://localhost

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=
    DB_USERNAME=
    DB_PASSWORD=

    EMAIL_FROM=
    ```

7) Execute : `php kernel migrate` to init DATABASE.
8) If you want generate fake data in database execute : `php kernel seed`.
    ```
    Admin : admin@mydnex.com
    Password : password
    ```