This is a school project for the course **Enterprise Software Application** taught in **Mines Saint-Étienne**.

Requirements :
- WAMP, MAMP, XAMPP : Solution stack with Apache, MariaDB, PHP
- [Composer][1] : Dependency Manager for PHP
- [Symfony CLI][2] : Symfony Command Line Interface

Run : 
1. Open WAMP
2. Open terminal,
3. Run `composer update` to update dependencies
4. Edit the `.env` file at line 26 and change the database credentials (`phpmyadmin_id`, `phpmyadmin_password` and `database_name`)
> `26 DATABASE_URL="mysql://phpmyadmin_id:phpmyadmin_password@127.0.0.1:3306/database_name?serverVersion=10.11.2-MariaDB&charset=utf8mb4"`
5. Run `php bin/console make:migration`then `php bin/console doctrine:migrations:migrate` to migrate the database.
6. Run `symfony server:start -d`
7. Go to http://localhost:8000/home

[1]https://getcomposer.org/
[2]https://symfony.com/
