
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

## Setting up Mailer

This project uses Laravel's built-in mailing system. To configure email sending:

1. Open the `.env` file and set the `MAIL_MAILER` variable to your desired mail driver (e.g., `smtp`, `mailtrap`, `sendmail`).

2. Configure the corresponding mail driver settings such as `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`, etc., based on your email service provider or local mail server.

For development, consider using services like [Mailtrap](https://mailtrap.io/) to simulate email sending without actually sending emails to real recipients.

---

## Setting up Cron Job

To enable Laravel's task scheduling:

1. Open your terminal and run:
   ```bash
   crontab -e
   ```

2. Add the following cron job entry to run Laravel's scheduler every minute:
   ```cron
   * * * * * php /path/to/php /path/to/project/artisan schedule:run >> /path/to/cron.log 2>&1
   ```

   Replace `/path/to/php`, `/path/to/project`, and `/path/to/cron.log` with the actual paths in your system.

This cron job will execute Laravel's scheduler every minute, and any scheduled tasks will be executed accordingly.

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
