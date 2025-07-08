# delinquent.id

![delinquent.id Banner](https://via.placeholder.com/1200x400?text=delinquent.id+Forum)

A modern, interactive forum platform built with Laravel and Livewire, designed for engaging discussions and community interaction.

## ✨ Features

*   **Thread Management:** Create, view, and manage discussion threads.
*   **Commenting System:** Engage in discussions with a rich commenting experience.
*   **Voting System:** Upvote/downvote threads and comments to highlight valuable content.
*   **User Authentication:** Secure user registration and login.
*   **Category Organization:** Browse threads by categories for easy navigation.
*   **Admin Panel (Filament):** Manage users, threads, categories, and more with an intuitive admin interface.
*   **Responsive Design:** A beautiful and functional interface across all devices.

## 🚀 Technologies Used

*   **Laravel 10.x:** The PHP Framework for Web Artisans.
*   **Livewire 3.x:** A full-stack framework for Laravel that makes building dynamic interfaces simple.
*   **Tailwind CSS:** A utility-first CSS framework for rapidly building custom designs.
*   **Alpine.js:** A rugged, minimal JavaScript framework for composing behavior directly in your markup.
*   **MySQL:** Robust and reliable database management.
*   **Filament:** A collection of tools for rapidly building beautiful TALL stack apps, including an admin panel.

## 📦 Installation

Follow these steps to get the project up and running on your local machine.

### Prerequisites

*   PHP >= 8.2
*   Composer
*   Node.js & npm (or Yarn)
*   MySQL (or another database supported by Laravel)

### Steps

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/your-username/delinquent-id.git
    cd delinquent-id
    ```

2.  **Install PHP dependencies:**
    ```bash
    composer install
    ```

3.  **Install Node.js dependencies:**
    ```bash
    npm install
    # OR
    yarn install
    ```

4.  **Copy the environment file:**
    ```bash
    cp .env.example .env
    ```

5.  **Generate application key:**
    ```bash
    php artisan key:generate
    ```

6.  **Configure your database:**
    Open the `.env` file and update the database credentials:
    ```dotenv
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=delinquent_id
    DB_USERNAME=root
    DB_PASSWORD=
    ```

7.  **Run database migrations and seeders:**
    ```bash
    php artisan migrate --seed
    ```
    This will create the necessary tables and populate them with some initial data (including a default admin user).

8.  **Link storage (if not already linked):**
    ```bash
    php artisan storage:link
    ```

9.  **Compile assets:**
    ```bash
    npm run dev
    # OR
    yarn dev
    ```
    For production, use `npm run build` or `yarn build`.

10. **Start the development server:**
    ```bash
    php artisan serve
    ```

    The application will be available at `http://127.0.0.1:8000`.

## 💡 Usage

*   **Frontend:** Access the forum at `http://127.0.0.1:8000`.
*   **Admin Panel:** Access the Filament admin panel at `http://127.0.0.1:8000/admin`. You can log in with the default admin user created by the seeder (check `database/seeders/UserSeeder.php` for credentials, typically `admin@example.com` / `password`).

## 🤝 Contributing

Contributions are welcome! Please see `CONTRIBUTING.md` (if available) for details on how to contribute.

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).