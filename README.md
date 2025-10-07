# Laravel Real Estate

Laravel Real Estate is a web application built with the Laravel framework, designed to streamline property management and real estate listings.
It provides an intuitive interface for administrators, agents, and users to manage properties, amenities, agent and user profiles, etc efficiently.

The system includes separate modules for admin and agent operations, leveraging Laravel’s MVC architecture.
Common features include property listing creation, media management (photos and videos), categorization by property type, and support for amenities and agent plans.

**Note**: The frontend assets (HTML, CSS, JavaScript, Bootstrap, Alpine.js, etc.) were pre-built and **not developed by me**. This project focuses exclusively on Laravel backend development and integration with the frontend.

## Features

The Laravel Real Estate application comes with a comprehensive set of features designed for property listing management, agent control, and an efficient administrative workflow.

### 🏠 Core Features

- **Property Management** – Create, update, and manage property listings with detailed descriptions, pricing, and location data.
- **Property Media** – Upload and manage multiple property photos and videos.
- **Amenities Management** – Define and assign amenities to properties (e.g., pool, parking, gym).
- **Property Types** – Organize listings by property types such as apartments, houses, offices, or land.

### 👤 Agent & User Features

- **Agent Accounts** – Manage agent profiles, plans, and listings associated with each agent.
- **Agent Authentication** – Secure login and dashboard for agents to manage their own properties.
- **Agent Plans** – Define plan levels or limits for property posting.

### ⚙️ Admin Features

- **Admin Dashboard** – Centralized control panel for managing agents, properties, and system data.
- **Access Control** – Middleware-protected routes for admin, agent and user sections.

### 🧩 Technical & Development Features

- **Built with Laravel 12** – Leverages Laravel’s latest features, including artisan commands, migrations, and model factories.
- **Modular Structure** – Clean separation of controllers, models, and views following Laravel’s MVC pattern.
- **RESTful Routes** – Organized route definitions.
- **Blade Templates** – Dynamic and reusable UI components using Laravel Blade.

## Installation
1. Clone the Repository:
```bash
git clone https://your-repo-url.git
cd laravel-real-estate-main
```
2. Install Dependencies:
```bash
composer install
```
3. Environment Setup:
```bash
cp .env.example .env
php artisan key:generate
```
4. Database Setup:
Configure your `.env` with your database credentials, then run:
```bash
php artisan migrate
```
5. Configure Email Settings.
Update your `.env` file with your own emial credentials to enable email functionality.

6. Run the Development Server:
```bash
php artisan serve
```

## Licence
This project is licensed under the MIT License.
