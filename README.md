# Getting started

## Installation

Please check the official laravel installation guide before you start. [Official Documentation](https://laravel.com/docs/8.x/installation)

Clone the repository

    git clone https://github.com/aelfannir/nextmedia-test.git

Switch to the repo folder

    cd nextmedia-test
    
Install backend dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env
    
Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate
    
Install frontend dependencies using composer

    npm install
    
Build assets

    npm run dev
    
Start the local development server

    php artisan serve

## CLI Features

* **Category**
    * Create: `php artisan category:create`
    * Delete: `php artisan category:delete`

* **Product**
    * Create: `php artisan product:create`
    * Delete: `php artisan product:delete`
