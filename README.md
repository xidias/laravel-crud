
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

## Usage

To start the Laravel development server, run:
```bash
php artisan serve
```
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

## Validation Rules

- Companies:
  ```php
  'name' => 'required|string|max:255',
  'email' => 'required|email|max:255',
  'description' => 'nullable|string',
  'website' => 'nullable|url',
  'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max size 2MB
  ```

- Employees:
  ```php
  'full_name' => 'required|string|max:255',
  'email' => 'required|email|max:255',
  'phone' => 'nullable|max:255',
  ```

- Categories:
  ```php
  'name' => 'required|string|max:255',
  'description' => 'nullable|string',
  ```

## License

This project is licensed under the [MIT License](LICENSE).

