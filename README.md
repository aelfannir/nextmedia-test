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


----------
# Testing
## Automated tests

    vendor\bin\phpunit --testsuite=Feature


## API test

Run the laravel development server

    php artisan serve

The api can now be accessed at

    http://localhost:8000/api
    
Available routes

| **Method**| **URI**           | **Description**       |
|----------	|------------------	|-----------------------|
| POST      | `/categories`     | Create new Category   |
| GET/HEAD  | `/categories`     | Get all Categories    |
| GET/HEAD  | `/categories/{id}`| Get a Category by id  |
| PUT/PATCH | `/categories/{id}`| Update Category by id |
| DELETE    | `/categories/{id}`| Delete Category by id |
| POST      | `/products`       | Create new Product    |
| GET/HEAD  | `/products`       | Get all Products      |
| GET/HEAD  | `/products/{id}`  | Get a Product by id   |
| PUT/PATCH | `/products/{id}`  | Update Product by id  |
| DELETE    | `/products/{id}`  | Delete Product by id  |
