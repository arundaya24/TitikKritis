# TitikKritis

**TitikKritis** is a web-based platform for people to submit complaints, criticism, and reports about problems around them.

The idea is pretty simple: instead of reporting problems manually or having information scattered everywhere, users can submit a report through one platform and track what happens to it.

This project was built as a Laravel project to practice building a real-world web application with authentication, database relationships, CRUD, user roles, and an admin dashboard.

## Features

### User

* Register and login
* Submit a complaint or criticism
* Choose a category for each report
* Track report status
* View report history
* Vote on reports
* View responses from admins or officers

### Admin / Officer

* View and manage submitted reports
* Update report status
* Respond to reports
* Manage report categories
* View report history
* Manage users

## Report Status

A report can have one of these statuses:

* **Pending** — waiting to be reviewed
* **Processing** — currently being handled
* **Completed** — the problem has been handled
* **Rejected** — the report cannot be processed

## Tech Stack

* **Laravel 12**
* **PHP**
* **MySQL**
* **Blade**
* **Bootstrap**
* **JavaScript**
* **Vite**
* **Laravel Breeze**
* **Git & GitHub**

## Getting Started

Clone the repository:

```bash
git clone https://github.com/arundaya24/TitikKritis.git
cd TitikKritis
```

Install PHP dependencies:

```bash
composer install
```

Install frontend dependencies:

```bash
npm install
```

Create the `.env` file:

```bash
copy .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

Configure your database inside `.env`, then run:

```bash
php artisan migrate
```

Start Vite:

```bash
npm run dev
```

In another terminal, run the Laravel development server:

```bash
php artisan serve
```

Then open the local URL provided by Laravel.

## Why I Built This

TitikKritis started as a school project, but I wanted to make it feel more like an actual application instead of just another basic CRUD project.

While building it, I got to work with things that are commonly used in real web applications, such as authentication, user roles, relational databases, report management, and admin dashboards.

There are still things that can be improved, but that's also part of the point of this project: learning how to build something bigger and gradually make it better.

## Project Structure

Some of the main parts of the application include:

* `Users` — user accounts
* `Critiques` — submitted reports and criticism
* `Categories` — report categories
* `Provinces` — province data
* `Regencies` — regency/city data
* `Districts` — district data
* `Critique Histories` — report activity history
* `Responses` — admin/officer responses
* `Votes` — report voting system

## Future Improvements

Some things I'd like to improve or add:

* Better notification system
* More detailed admin analytics
* Better report filtering and search
* Improved UI/UX
* More complete authorization system
* Deployment and production optimization

## Developer

**Kalingga Arundaya**

GitHub: [@arundaya24](https://github.com/arundaya24)
