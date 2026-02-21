# 🏨 **Book-My-Hotel – Sustainable Hotel Booking Platform**

Book-My-Hotel is a Laravel-based hotel reservation platform designed to support sustainable tourism by helping customers easily browse, compare, and book eco-friendly hotels. The system includes customer booking, hotel management, admin analytics, review & rating features, and sustainability reward tracking.

This project was developed as part of the **SWE6013 Enterprise Programming module** using **MVC architecture** and follows a Waterfall development model.

---

# 📌 **Overview**

BookMyHotel is an online booking platform that allows:

- 🌍 **Customers** to search for hotels, book rooms, write reviews, and earn sustainability rewards
- 🏨 **Hotel Managers** to manage hotels, rooms, promotions, and view performance insights
- 👨‍💼 **Admins** to manage the platform, moderate content, and view analytics

The platform focuses on **clarity**, **sustainability**, **transparency**, and **ease of booking**, aligning with customer and business needs.

---

# ⭐ **Features**

## 👤 _Customer Features_

- Register/Login
- Browse & search hotels
- Filter by facilities (WiFi, pool, sustainability friendly, etc.)
- Book rooms with availability validation
- View, Cancel, and manage bookings
- Payments & refunds
- Write and edit reviews (1 per hotel)
- Customer dashboard (spending, points, booking status)

## 🏨 _Hotel Manager Features_

- Manage hotel profile
- Add/edit/delete rooms
- Create promotions
- View bookings & manage refunds
- Manager dashboard (revenue, occupancy, rating)

## 👨‍💼 _Admin Features_

- Manage users
- Manage hotels
- Manage rooms
- Manage discount codes
- View bookings
- Admin analytics dashboard

## 🛠️ _System Features_

- Laravel MVC architecture
- Secure authentication & CSRF protection
- Spatie Roles & Permissions
- Form Requests for validation
- MySQL database

---

# 🧱 **Tech Stack**

| Layer                 | Technology                   |
| --------------------- | ---------------------------- |
| **Backend Framework** | Laravel 12                   |
| **Frontend**          | Blade Templates, Bootstrap 5 |
| **Database**          | MySQL                        |
| **Authentication**    | Laravel UI                   |
| **Authorization**     | Spatie Laravel Permission    |
| **Version Control**   | Git / GitHub                 |

---

# 🏛 **System Architecture**

The project follows the **Laravel MVC architecture**, including:

- Controllers
- Models (Eloquent ORM)
- Form Requests (validation layer)
- Blade Views
- Migrations & Seeders
- MySQL Database

---

# ⚙️ **Installation**

### 1. Clone the repository

     git clone https://github.com/Mustafa21102005/Book-My-Hotel.git

### 2. Open the project in Your Preferred Text Editor

- Open the project folder in a text editor or IDE of your choice (e.g., VS Code, PhpStorm).

### 3. Rename `.env.example` to `.env`

- In the project root, rename the `.env.example` file to `.env`.
- Insert your **database connection information** and other environment-specific configurations in the `.env` file like **email connection**.

### 4. Install PHP Dependencies

- Open your terminal and navigate to the project directory.
- Run the following command to install PHP dependencies:

    ```
    composer install
    ```

### 5. Generate Application Key

- Next, generate the application key by running:

    ```
    php artisan key:generate
    ```

### 6. Install Node.js Dependencies

- Install Node.js dependencies by running the following command:

    ```
    npm install
    ```

### 7. Run Database Migrations and Seeders

- To set up the database schema and seed your database with initial data, run the following command:

    ```
    php artisan migrate --seed
    ```

### 8. Run Laravel Schedule

- To start the automation of scanning for bookings that are completed today and mark them as complete and send an email to the customer:

    ```
    php artisan schedule:work
    ```

### 9. Run Laravel Queues

- To start the queues and send emails to users:

    ```
    php artisan queue:work
    ```

### 10. Run the Project

- Finally, you can start the development server by running:

    ```
    php artisan serve
    ```

- Your application will be live at `http://127.0.0.1:8000`.

### 🎉 You're Ready to Go!

Now you can start using the project! 🎉
