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
3. In your terminal navigate to the projects directory `cd ~/{path_to_the_project}`
4. Make sure you have the project's composer packages installed by running the following command, `composer install`
5. Run the projects migrations by running the following command, `php artisan migrate`
6. To serve the application run the following command in your terminal, `php -S localhost:8000 -t public`

### Running the code

For the purpose of this tech test I have used Postman client to send the REST API requests.
I have provided the export file `psn-tech-test-php.postman_collection.json` so you can easily import the collection to run the code.
In the collection you will find 5 endpoints:
1. `Task 1a: Creates Videos`
2. `Task 1b: Gets a list of all videos`
3. `Task 2: Gets a video`
4. `Task 3: Deletes a Video`
5. `Task 4: Gets a filtered list of videos`

### Running the tests

To run the feature tests run the following in the project directory:
```composer test-dox```
