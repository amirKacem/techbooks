Tech Books a public books libary based on Symfony 4
# Installation
------------
1. Clone or download repository
     ```
     https://github.com/amirKacem/techbooks.git
     ```
     
2. Run Composer 
    ```
    composer install
    ```
3. configure the database in .env

    # MYSQL / MariaDB
    DATABASE_URL="mysql://root:@127.0.0.1:3306/techbooks"

4. create database and load fixtures
    ```
    
    php bin/console doctrine:database:create
    
    php bin/console doctrine:migrations:migrate
    
    php bin/console doctrine:fixtures:load
     ```
5. Run Server
    ```
    
    php bin/console server:run
    ```

Authentification
-----------------

**Use these credentials to log in as Admin **
    go to http://localhost:8000/login

    username : admin

    password : admin
