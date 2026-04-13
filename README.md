# TaskFlow — Task Management System

> Qtec Solution Limited — Technical Assessment

## Tech Stack
- **Backend**: PHP 8.2+, Laravel 11
- **Frontend**: Blade, Vanilla CSS (dark theme)
- **Database**: MySQL 8
- **Testing**: PHPUnit

## Setup

```bash
git clone <repo-url>
cd taskflow
composer install
cp .env.example .env
php artisan key:generate
# .env এ DB credentials দাও
php artisan migrate
php artisan db:seed
php artisan serve
```

Visit: http://127.0.0.1:8000

## Run Tests

```bash
php artisan test
```

## Features
- Task CRUD (Create, Read, Update, Delete)
- Status tracking: Pending → In Progress → Completed
- Priority levels: Low, Medium, High
- Due date with overdue detection
- Search & filter by status/priority
- Dashboard with stat cards
- 35 automated tests
