Football Manager

The Football Manager project is a football management system that allows you to manage teams and players.
Installation

    Clone this code repository by running the following command:

    

git clone https://github.com/your-username/football-manager.git

Navigate to the project directory:


cd football-manager

Install the dependencies by running the following command:

composer install

Configure the database connection settings by editing the .env file and updating the values of DATABASE_URL to match your database configuration.

Create the database by running the following command:

php bin/console doctrine:database:create

Import the database by running:

symfony console doctrine:database:import football.sql

After importing the database file, you need to update schema to reflect the changes. You can do this by running the following command:

symfony console doctrine:schema:update --force


Start the Symfony development server:


    symfony server:start

    The project is now accessible at http://localhost:8000.

Usage

    Access the application using the above URL.
    Create teams and players.
    Manage player transfers between teams.
    View information about teams and players.

Tests

To run the tests, use the following command:

vendor/bin/phpunit
