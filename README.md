# Mydnex Blog

Create your first blog in php.


## Installation

1) Clone the project.
2) Change the root directory of Apache `DocumentRoot /path/to/my/project`  or move the project to `/var/www/html`.
3) Install composer with `composer install & composer dump-autoload` .
4) Install npm with `npm install & npm run dev` .
5) Add in the root of the project a new file .env with 

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

6) Execute : `php kernel migrate` to init DATABASE.
7)  If you want generate fake data in database execute : `php kernel seed`.
    ```
    Admin : admin@mydnex.com
    Password : password
    ```