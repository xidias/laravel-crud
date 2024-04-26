
markdown
# Laravel CRUD Project

This Laravel project implements CRUD (Create, Read, Update, Delete) functionality for managing companies, employees, and categories.

---

## Requirements

- Laravel 11.4
- PHP >= 7.4
- Composer
- Node.js and npm (Optional for asset compilation)

---

## Installation

1. **Clone the repository:**

   ```bash
   git clone https://github.com/xidias/laravel-crud.git
   ```

2. **Navigate to the project directory:**

   ```bash
   cd laravel-crud
   ```

3. **Install PHP dependencies:**

   ```bash
   composer install
   ```

4. **Configure environment:**

   - Copy the `.env.example` file to `.env`:

     ```bash
     cp .env.example .env
     ```

   - Update the `.env` file with your database settings.

5. **Generate the application key:**

   ```bash
   php artisan key:generate
   ```

6. **Run database migrations:**

   ```bash
   php artisan migrate
   ```

7. **Create symbolic link for storage:**

   ```bash
   php artisan storage:link
   ```

   This links `public/storage` to `storage/app/public` for file access from the web.

8. **(Optional) Install Node.js and npm:**

   Check if Node.js and npm are installed:

   ```bash
   node -v
   npm -v
   ```

   If not installed, follow Node.js documentation.

   Install npm dependencies:

   ```bash
   npm install
   ```

   Install cross-env package if not installed globally:

   ```bash
   npm install -g cross-env
   ```

9. **Compile assets (if needed):**

   - For development:

     ```bash
     npm run dev
     ```

   - For production (minified assets):

     ```bash
     npm run prod
     ```

10. **Start development server:**

    ```bash
    php artisan serve
    ```

    Access the application at `http://127.0.0.1:8000`.

---

## Usage

- Register as an admin or moderator.
- Admins have full CRUD permissions for companies, employees, and categories.
- Moderators can modify companies and employees.
- Use the provided login functionality to access the CRUD operations.

---

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

---

## License

This project is licensed under the [MIT License](LICENSE).