# PSN Tech Test 
## API design in PHP

A RESTful API to perform create, read, deletion and search functionality.

### Project Setup for mac 

1. Install following if you havent already done so:
    1. homebrew - `/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"`
    2. php - `brew install php`
    3. composer - `brew install composer`
    4. mysql - `brew install mysql`
2. Create the database by running the following in a new terminal:
    1. `mysql -u root -p` (password should be blank)
    2. `CREATE DATABASE psntechtest;`
3. In your terminal navigat to the projects directory `cd ~/{path_to_the_project}`
4. Make sure you have the projects composer packages installed by running the following command, `composer install`
5. To serve the application run the following command in your terminal, `php -S localhost:8000 -t public`
