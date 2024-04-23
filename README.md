
# Laravel CRUD Project

This Laravel project implements CRUD (Create, Read, Update, Delete) functionality for managing companies, employees, and categories.

## Requirements

- Laravel 11.4
- PHP >= 7.4
- Composer

## Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/xidias/laravel-crud.git
   ```

2. Navigate to the project directory:

   ```bash
   cd laravel-crud
   ```

3. Install PHP dependencies:

   ```bash
   composer install
   ```

4. Copy the `.env.example` file to `.env` and configure your database settings:

   ```bash
   cp .env.example .env
   ```

   Update the database name, username, password, and other settings in the `.env` file.

5. Generate the application key:

   ```bash
   php artisan key:generate
   ```

6. Run the database migrations:

   ```bash
   php artisan migrate
   ```

7. If your Laravel application uses Laravel Mix for compiling assets (CSS, JavaScript), you need to run the Mix commands. Typically, this involves running `npm install` to install dependencies and then running one of the following commands based on your needs:

   - For development:
     ```bash
     npm run dev
     ```
   - For production (minified assets):
     ```bash
     npm run prod
     ```

## Usage

- Register as an admin or moderator.
- Admins have full CRUD permissions for companies, employees, and categories.
- Moderators can modify companies and employees.
- Use the provided login functionality to access the CRUD operations.

## Features

- **Companies:**
  - Create, read, update, delete companies.
  - Fields: Name, Email, Description, Website, Logo (Image upload supported).

- **Employees:**
  - Create, read, update, delete employees.
  - Fields: Full Name, Email, Phone.

- **Categories:**
  - Create, read, update, delete categories.
  - Fields: Name, Description.

## License

This project is licensed under the [MIT License](LICENSE).

