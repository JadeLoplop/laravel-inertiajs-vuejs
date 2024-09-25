# Running the Project Locally

## Environment Setup

1.  **Clone the repository** to your local machine:
    
    -   Use the command to clone your project repository from GitHub.
2.  **Set up the `.env` file**:
    
    -   Copy the `.env.example` file and rename it to `.env`.
    -   Update the database settings in the `.env` file to match your local database configuration.
3.  **Create a new database**:
    
    -   Ensure you have created a database that matches the name specified in your `.env` file under the `DB_DATABASE` variable.

## Installing Dependencies

-   Run the following commands to install the necessary PHP and JavaScript packages:
    -   For PHP dependencies, run:
        -   `composer install`
    -   For JavaScript dependencies, run:
        -   `npm install`

## Compiling Assets

-   Compile your assets by running:
    -   `npm run dev`

## Database Migration

-   Run the database migrations to set up the necessary tables:
    -   `php artisan migrate`

## Importing Initial Data

-   To import initial data, execute the import command:
    -   `php artisan import:users-posts`

## Running the Development Server

-   Start the local development server:
    -   `php artisan serve`

## Accessing the Application

-   Open your web browser and go to `http://localhost:8000` to access the application.
