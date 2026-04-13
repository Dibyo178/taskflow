# TaskFlow

A lightweight task management system built as part of the Qtec Solution Limited Full Stack Laravel Developer assessment. The application allows teams to create, organize, and track tasks with status progression, priority levels, and deadline management — all within a clean, responsive interface.

---

## Table of Contents

- [Tech Stack](#tech-stack)
- [Features](#features)
- [Project Structure](#project-structure)
- [Getting Started](#getting-started)
- [Running Tests](#running-tests)
- [Testing Strategy](#testing-strategy)
- [Design Decisions](#design-decisions)

---

## Tech Stack

- **Framework** — Laravel 11 (PHP 8.2+)
- **Templating** — Blade
- **Styling** — Custom CSS (no build pipeline required)
- **Database** — MySQL 8
- **Testing** — PHPUnit via Laravel's test suite
- **Typography** — Syne + DM Sans via Google Fonts

---

## Features

- Full task CRUD with form validation
- Three-stage status flow: Pending → In Progress → Completed
- Priority tagging: Low, Medium, High
- Due date support with automatic overdue detection
- Quick status updates from the task detail view
- Title search with status and priority filtering
- Paginated task grid (9 per page)
- Summary dashboard with live task counts
- Flash notifications with auto-dismiss
- Mobile-responsive layout

---

## Project Structure

```
taskflow/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── TaskController.php          # Handles all task-related HTTP requests
│   │   └── Requests/
│   │       ├── StoreTaskRequest.php         # Validation rules for task creation
│   │       └── UpdateTaskRequest.php        # Validation rules for task updates
│   └── Models/
│       └── Task.php                         # Task model with scopes and accessors
│
├── database/
│   ├── factories/
│   │   └── TaskFactory.php                  # Fake data generation for tests and seeding
│   ├── migrations/
│   │   └── xxxx_xx_xx_create_tasks_table.php
│   └── seeders/
│       └── DatabaseSeeder.php               # Seeds 18 demo tasks on fresh install
│
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php                # Shared layout: sidebar, topbar, alerts
│       └── tasks/
│           ├── index.blade.php              # Dashboard with stats, filters, task grid
│           ├── create.blade.php             # New task form
│           ├── edit.blade.php               # Edit task form
│           └── show.blade.php               # Task detail with quick status controls
│
├── routes/
│   └── web.php                              # Application route definitions
│
├── tests/
│   ├── Feature/
│   │   └── TaskControllerTest.php           # End-to-end HTTP tests
│   └── Unit/
│       ├── TaskModelTest.php                # Isolated model logic tests
│       └── StoreTaskRequestTest.php         # Form validation rule tests
│
├── .env.example
├── composer.json
└── README.md
```

---

## Getting Started

### Prerequisites

Ensure the following are available on your system before proceeding.

| Requirement | Version |
|---|---|
| PHP | 8.2 or higher |
| Composer | 2.x |
| MySQL | 8.x |
| Git | Any recent version |

> **Windows users:** [XAMPP](https://www.apachefriends.org) is the quickest way to get PHP and MySQL running locally. Install Composer separately afterward.

---

### Installation

**1. Clone the repository**

```bash
git clone https://github.com/your-username/taskflow.git
cd taskflow
```

**2. Install dependencies**

```bash
composer install
```

**3. Set up environment file**

```bash
cp .env.example .env
php artisan key:generate
```

**4. Configure the database**

Open `.env` and update the database section:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=taskflow
DB_USERNAME=root
DB_PASSWORD=
```

Create the `taskflow` database in MySQL before the next step. If using XAMPP, this can be done via [phpMyAdmin](http://localhost/phpmyadmin).

**5. Run migrations and seed demo data**

```bash
php artisan migrate
php artisan db:seed
```

This creates the `tasks` table and inserts 18 sample tasks across different statuses and priorities.

**6. Start the development server**

```bash
php artisan serve
```

The application will be available at **http://127.0.0.1:8000**.

---

## Running Tests

The development server must remain running in one terminal. Open a **second terminal** for test commands.

**Run the full test suite**

```bash
php artisan test
```

**Run only feature tests**

```bash
php artisan test --testsuite=Feature
```

**Run only unit tests**

```bash
php artisan test --testsuite=Unit
```

**Run a single test class**

```bash
php artisan test tests/Feature/TaskControllerTest.php
```

**Expected output**

```
PASS  Tests\Unit\StoreTaskRequestTest
PASS  Tests\Unit\TaskModelTest
PASS  Tests\Feature\TaskControllerTest

Tests: 23 passed
```

---

## Testing Strategy

The test suite is organized into three layers, each targeting a different concern.

**Feature Tests — TaskControllerTest**

These tests make real HTTP requests against the full application stack and verify end-to-end behavior from route through to database state. They cover the complete task lifecycle: listing, filtering, searching, creating, viewing, editing, status patching, and deletion — including edge cases such as 404 responses and validation failures.

**Model Unit Tests — TaskModelTest**

These tests exercise the Task model in isolation from the HTTP layer. They verify that query scopes (`byStatus`, `byPriority`, `overdue`) return the correct records, that computed properties (`isOverdue`, `statusBadgeClass`) produce the right values, and that date casting behaves as expected.

**Validation Unit Tests — StoreTaskRequestTest**

These tests instantiate the `StoreTaskRequest` form request class directly and run the validator against a range of inputs. This allows thorough coverage of validation rules — required fields, enum constraints, past date rejection — without the overhead of full HTTP dispatching.

This structure keeps each concern independently testable. Model bugs surface in unit tests before feature tests are reached, which makes failures faster to diagnose and fix.

---

## Design Decisions

**Dedicated Form Request classes**
All input validation is handled through `StoreTaskRequest` and `UpdateTaskRequest` rather than inline controller logic. This keeps controllers focused on orchestration and makes validation rules independently testable.

**Business logic on the model**
Computed properties such as `isOverdue` and query scopes such as `scopeOverdue` live on the `Task` model rather than in controllers or views. This avoids duplication, keeps the model cohesive, and makes the logic straightforward to unit test.

**No front-end build pipeline**
The interface is built with plain CSS using custom properties. This removes the need for Node.js or any asset compilation step — `composer install` followed by `php artisan serve` is sufficient to run the project locally.

**Authentication excluded**
The assessment scope was focused on task management. Authentication was deliberately omitted to stay within the time frame and keep the codebase concentrated on the areas being evaluated. Laravel Breeze could be layered in with minimal changes.

**In-memory SQLite for tests**
The `phpunit.xml` environment is configured to use an in-memory SQLite database. Tests run against a clean, isolated state on every execution and never touch the local MySQL database.

---

*Submitted for Qtec Solution Limited — Full Stack Laravel Developer Assessment — 2026*
