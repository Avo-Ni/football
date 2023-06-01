Football Manager

The Football Manager project is a football management system that allows you to manage teams and players.
Installation

    Clone this code repository by running the following command:

  

git clone https://github.com/Avo-Ni/football.git

    Navigate to the project directory:

  

cd football

    Install the dependencies by running the following command:

  

composer install

    Install the Vue.js dependencies by running the following command:

  

npm install

    Configure the database connection settings by editing the .env file and updating the values of DATABASE_URL to match your database configuration.

    Create the database by running the following command:

  

symfony console doctrine:database:create

    Import the database by running the following command:

  

symfony console doctrine:database:import football.sql

    After importing the database file, you need to update the schema to reflect the changes. You can do this by running the following command:

  

symfony console doctrine:schema:update --force

Startup

Type this command: 

npm run build

Start the server by running the following command:

symfony server:start

The project is now accessible at http://localhost:8000.

 
Usage

    Access the application using the above URL.
    Create teams and players.
    Manage player transfers between teams.
    View information about teams and players.

