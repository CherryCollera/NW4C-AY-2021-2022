<p align="center"><a href="#" target="_blank"><img src="public/img/logo3.webp" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About E-Barter

E-Barter is a blah blah blah insert explanation

-   Insert some features here
-   Insert some more features here.
-   Features 1
-   Features 2
-   Features 3
-   Features 4
-   Features 5

## Prerequisites

Make sure the following software is installed and set up

-   [NPM](https://phoenixnap.com/kb/install-node-js-npm-on-windows)
-   [Composer](https://getcomposer.org/download/)
-   [PostgreSQL](https://www.2ndquadrant.com/en/blog/pginstaller-install-postgresql/)
-   [Git](https://github.com/git-guides/install-git)
-   [Github CLI](https://github.com/cli/cli#installation)

### Setting up on Local Environment

1. Clone the project

```
gh repo clone poodzia/ebarter-v3
```

2. Copy .env file

```
cp .env.example .env
```

3. Make a database in postgresql with the following configuration

```
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=ebarter_v3
DB_USERNAME=kel
DB_PASSWORD=Password1
```

4. Install dependencies

```
npm install && composer install
```

5. Migrate database tables and run the seeder class

```
php artisan migrate:fresh --seed
```

6. Make a symlink to local storage

```
php artisan storage:link
```

7. Compile the project and watch for changes

```
npm run hot
```

8. Run the server and follow the the link this command will output

```
php artisan serve
```

9. Get new changes in the repository by running

```
git pull origin master
```
