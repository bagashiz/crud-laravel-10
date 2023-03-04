# Description

This is simple CRUD post app built with laravel 10.0 web framework.

## Dependencies

- [PHP](https://www.php.net/) 8.1.0 or higher
- [Composer](https://getcomposer.org/) 2.5.4 or higher
- [MySQL](https://www.mysql.com/) 8.0 or higher
- [make](https://www.gnu.org/software/make/) (optional)
- [Podman](https://podman.io/) or [Docker](https://www.docker.com/) (optional)
- [MySQL 8.0 Docker image](https://hub.docker.com/_/mysql) (optional)

## Setup

1. Clone this repository and go to the project directory, then install the dependencies.

    ```bash
    git clone https://github.com/bagashiz/crud-laravel-10.git
    cd crud-laravel-10
    composer install
    ```

### Using Podman

1. Run the following make commands to setup the database.

    ```bash
    make mysql
    make createdb
    make migrate
    make serve
    ```

2. Start the PHP server.

    ```bash
    php artisan serve
    ```

3. Go to `http://localhost:8000` in your browser.

### Using Docker

Change the `podman` commands to `docker` in the Makefile, then follow the same steps as above.

## Learning and Reference Sources

- [Santri Koding - Tutorial Laravel 10 untuk Pemula](https://santrikoding.com/tutorial-set/tutorial-laravel-10-untuk-pemula)
