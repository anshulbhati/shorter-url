Welcome Laravel Url Generator File 

- PHP >= 8.1
- Composer
- MySQL
- Laravel 10 / 11
- Git 

step 1:

clone project Using Git 

step 2:
    Create .env file 
    run : cp .env.example .env
    create .env-key 
    run : php artisan key:generate 

    change .env file Database 
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=shorter_url
    DB_USERNAME=root
    DB_PASSWORD=

    #change also session in env file
    SESSION_DRIVER=file
step 3
    Composer install for vendor Folder dependancy
    run: composer install
step 4 
    insert database in Mysql Folder  And Super Admin And ROleSeeder
    php artisan migrate --seed
step 6 
    run project run command behind for mail without delay both command are required
    run : php artisan serve
    run : php artisan queue:listen

I'm Using in this project 
1.migration for create a schema 
2.seeder for create superadmin credentails
3.middleware for project route And Authentication 
4 Authentication for user authentic or not 
5 gates for Authrization 
6 Mail for Invite
7 Queue for Without Delay the mail

Help chatGpt For Debug if i'm facing any bug mostly bug type spelling mistakes,for Small UI
help Bootstrap for UI
thank You 
    
    


