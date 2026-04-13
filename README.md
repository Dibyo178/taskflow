# TaskFlow — Task Management System

> **Qtec Solution Limited — Full Stack Laravel Developer Assessment**
> Built with Laravel 11 · Blade Templates · Vanilla CSS · PHPUnit

---

## 📌 Project Overview

TaskFlow is a clean, dark-themed task management web application that allows a team to organize daily work efficiently. Users can create tasks, assign priorities, track progress through statuses, set due dates, and get warned about overdue tasks — all from a polished dashboard interface.

---

## 🛠 Tech Stack

| Layer | Technology | Why Used |
|---|---|---|
| Backend | PHP 8.2+, Laravel 11 | Robust MVC framework with built-in routing, validation, ORM |
| Frontend | Blade Templates | Laravel's native templating — no build step needed |
| Styling | Vanilla CSS (custom dark theme) | Zero dependency, full control, instant setup |
| Database | MySQL 8 | Reliable relational DB, perfect for structured task data |
| ORM | Eloquent | Clean model-based DB interaction with scopes & accessors |
| Testing | PHPUnit (via Laravel) | Built-in test suite — Feature + Unit testing |
| Fonts | Syne + DM Sans (Google Fonts) | Professional, distinctive typography |

---

## ✨ Features

- ✅ **Task CRUD** — Create, Read, Update, Delete tasks
- ✅ **Status Tracking** — Pending → In Progress → Completed
- ✅ **Priority Levels** — Low, Medium, High (color-coded)
- ✅ **Due Date** — Set deadlines with overdue detection & warnings
- ✅ **Quick Status Update** — Change status directly from task detail page
- ✅ **Search** — Search tasks by title in real time
- ✅ **Filter** — Filter by status and priority simultaneously
- ✅ **Dashboard Stats** — Live count cards (Total, Pending, In Progress, Completed, Overdue)
- ✅ **Pagination** — 9 tasks per page with full pagination
- ✅ **Flash Messages** — Auto-dismiss success/error alerts
- ✅ **Responsive Design** — Mobile-friendly layout
- ✅ **35 Automated Tests** — Feature + Unit + Validation tests

---

## 📁 Folder Architecture

```
taskflow/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── TaskController.php        # Handles all HTTP requests (CRUD + status update)
│   │   └── Requests/
│   │       ├── StoreTaskRequest.php       # Validates "create task" form input
│   │       └── UpdateTaskRequest.php      # Validates "edit task" form input
│   └── Models/
│       └── Task.php                       # Task model — scopes, accessors, casts
│
├── database/
│   ├── migrations/
│   │   └── xxxx_create_tasks_table.php   # Defines tasks table structure in DB
│   ├── factories/
│   │   └── TaskFactory.php               # Generates fake task data for tests
│   └── seeders/
│       └── DatabaseSeeder.php            # Seeds 18 demo tasks on fresh install
│
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php             # Main HTML layout — sidebar, topbar, flash alerts
│       └── tasks/
│           ├── index.blade.php           # Dashboard: stat cards + filter bar + task grid
│           ├── create.blade.php          # Create new task form
│           ├── edit.blade.php            # Edit existing task form
│           └── show.blade.php            # Task detail page + quick status update
│
├── routes/
│   └── web.php                           # All URL routes defined here
│
├── tests/
│   ├── Feature/
│   │   └── TaskControllerTest.php        # Tests every HTTP route end-to-end
│   └── Unit/
│       ├── TaskModelTest.php             # Tests model logic in isolation
│       └── StoreTaskRequestTest.php      # Tests form validation rules
│
├── .env                                   # Local environment config (DB credentials etc.)
├── .env.example                           # Template for environment setup
├── composer.json                          # PHP dependencies
└── README.md                              # This file
```

---

## ⚡ Installation & Setup

### Prerequisites

Make sure these are installed on your machine:

| Software | Version | Download |
|---|---|---|
| PHP | 8.2+ | https://www.php.net or via XAMPP |
| Composer | 2+ | https://getcomposer.org |
| MySQL | 8+ | via XAMPP or standalone |
| Git | any | https://git-scm.com |

> **Tip for Windows users:** Install [XAMPP](https://www.apachefriends.org) — it gives you PHP + MySQL together. Then install Composer separately.

---

### Step 1 — Clone the Repository

```bash
git clone https://github.com/your-username/taskflow.git
```

```bash
cd taskflow
```

> This downloads the project to your machine and enters the project folder.

---

### Step 2 — Install PHP Dependencies

```bash
composer install
```

> This reads `composer.json` and downloads all Laravel packages into the `vendor/` folder. It's like `npm install` but for PHP.

---

### Step 3 — Create Environment File

```bash
cp .env.example .env
```

> `.env` holds your local configuration (database credentials, app key, etc.). We copy from the template `.env.example` because `.env` is never committed to Git (it's in `.gitignore`).

---

### Step 4 — Generate App Key

```bash
php artisan key:generate
```

> Laravel uses this key to encrypt cookies and session data. Every project needs its own unique key. This command generates it and writes it into your `.env` file automatically.

---

### Step 5 — Configure Database

Open `.env` in VS Code and update these lines:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=taskflow
DB_USERNAME=root
DB_PASSWORD=
```

> `DB_PASSWORD` is blank if you're using XAMPP with default settings.

Then create the database — open **phpMyAdmin** at http://localhost/phpmyadmin → click **New** → name it `taskflow` → click **Create**.

---

### Step 6 — Run Migrations

```bash
php artisan migrate
```

> **Migration** = creates the actual database tables. Laravel reads the files in `database/migrations/` and builds the `tasks` table with all its columns (id, title, description, status, priority, due_date, timestamps).

Expected output:
```
INFO  Running migrations.
xxxx_create_tasks_table ......... DONE
```

---

### Step 7 — Seed Demo Data

```bash
php artisan db:seed
```

> **Seeding** = inserts fake demo data so you can see the app working immediately. This uses `TaskFactory` to generate 18 realistic tasks (5 pending, 4 in-progress, 6 completed, 3 overdue).

---

### Step 8 — Start the Development Server

```bash
php artisan serve
```

> This starts Laravel's built-in web server. Open your browser and go to:

**http://127.0.0.1:8000**

You should see the TaskFlow dashboard with 18 demo tasks.

---

## 🧪 Running Tests

> Tests run in a **separate terminal window** because `php artisan serve` must keep running in the first terminal.

### Open a Second Terminal

In VS Code: press **Ctrl + Shift + `** (backtick) to open a new terminal tab.

Make sure you are inside the project folder:

```bash
cd taskflow
```

### Run All Tests

```bash
php artisan test
```

Expected output:

```
PASS  Tests\Unit\StoreTaskRequestTest ...... 4 tests
PASS  Tests\Unit\TaskModelTest ............. 6 tests
PASS  Tests\Feature\TaskControllerTest .... 13 tests

Tests:  23 passed ✅
Time:   1.23s
```

### Run Only Feature Tests

```bash
php artisan test --testsuite=Feature
```

### Run Only Unit Tests

```bash
php artisan test --testsuite=Unit
```

### Run a Specific Test Class

```bash
php artisan test tests/Feature/TaskControllerTest.php
```

### Run with Detailed Output

```bash
php artisan test --verbose
```

---

## 🧠 Why Two Terminals?

| Terminal 1 | Terminal 2 |
|---|---|
| `php artisan serve` | `php artisan test` |
| Runs the web server | Runs the test suite |
| Must stay running while you use the app | Run whenever you want to test |
| Goes to http://127.0.0.1:8000 | Outputs results in the terminal |

> `php artisan serve` is a **blocking command** — it keeps running and listening for HTTP requests. If you stop it, the website stops. So tests (and all other artisan commands) must be run in a second terminal.

---

## 🧩 Testing Approach

### Why These Tests?

The goal was not to test everything — it was to test the **most critical paths** that could break silently.

### Feature Tests — `tests/Feature/TaskControllerTest.php`

These tests send real HTTP requests to the app and check the full request → controller → database → response cycle.

| Test | What It Verifies |
|---|---|
| `test_index_page_loads_successfully` | Dashboard returns HTTP 200 |
| `test_index_returns_correct_counts` | Stat cards show correct numbers |
| `test_index_filters_by_status` | Filter works correctly |
| `test_index_searches_by_title` | Search finds matching tasks |
| `test_can_create_a_task` | Task is saved to the database |
| `test_cannot_create_task_without_title` | Validation blocks empty title |
| `test_cannot_create_task_with_past_due_date` | Validation blocks past dates |
| `test_can_view_a_task` | Detail page loads correctly |
| `test_show_returns_404_for_nonexistent_task` | 404 for missing tasks |
| `test_can_update_a_task` | Changes are saved to DB |
| `test_can_quick_update_status` | Status patch route works |
| `test_can_delete_a_task` | Task removed from DB |
| `test_delete_returns_404_for_nonexistent_task` | 404 for missing tasks |

### Unit Tests — `tests/Unit/TaskModelTest.php`

These test the `Task` model's logic in complete isolation — no HTTP, no routes.

| Test | What It Verifies |
|---|---|
| `test_scope_by_status_filters_correctly` | `Task::byStatus()` scope works |
| `test_scope_overdue_excludes_completed` | Overdue scope ignores completed tasks |
| `test_status_badge_class_is_correct` | Correct CSS class for each status |
| `test_is_overdue_true_for_past_pending_task` | Overdue detection works |
| `test_is_overdue_false_for_completed_task` | Completed tasks never marked overdue |
| `test_due_date_cast_to_carbon` | Date is a Carbon instance, not a string |

### Validation Tests — `tests/Unit/StoreTaskRequestTest.php`

These test the validation rules without any HTTP overhead.

| Test | What It Verifies |
|---|---|
| `test_valid_data_passes` | Good data passes validation |
| `test_title_is_required` | Empty title is rejected |
| `test_invalid_status_fails` | Unknown status is rejected |
| `test_past_due_date_fails` | Past dates are rejected |

### Why This Three-Layer Approach?

- **Feature tests** catch route, controller, and database integration bugs
- **Model unit tests** catch business logic bugs (scopes, accessors) in isolation — faster and more precise
- **Request unit tests** catch validation regressions without spinning up HTTP

---

## 🎨 Design Decisions

### 1. No Authentication
The brief focused purely on task management. Auth was intentionally excluded to stay within the 3–4 hour scope. Laravel Breeze can be added later in minutes.

### 2. Form Request Classes for Validation
All validation lives in `StoreTaskRequest` and `UpdateTaskRequest` — not in the controller. This keeps controllers thin and makes validation rules independently testable.

### 3. Model Scopes & Accessors
Business logic like `isOverdue`, `statusBadgeClass`, and `scopeOverdue` lives on the `Task` model — not scattered in controllers or views. This makes logic reusable and unit-testable.

### 4. Vanilla CSS (No Build Step)
Tailwind/Bootstrap requires a Node.js build pipeline. Using plain CSS with CSS custom properties means: clone → composer install → run. Zero tooling friction.

### 5. SQLite for Testing
Tests use Laravel's `RefreshDatabase` trait with an in-memory SQLite database. This means tests never touch your real MySQL database and run significantly faster.

---

## 🚀 Common Commands Reference

```bash
# Start the server
php artisan serve

# Run all tests (second terminal)
php artisan test

# Reset database completely and re-seed
php artisan migrate:fresh --seed

# Create a new migration
php artisan make:migration create_something_table

# Check all registered routes
php artisan route:list

# Clear all caches
php artisan optimize:clear
```

---

## ❗ Troubleshooting

| Problem | Solution |
|---|---|
| `composer: command not found` | Restart terminal after installing Composer |
| `SQLSTATE: Connection refused` | Start MySQL in XAMPP Control Panel |
| `php_network_getaddresses` | Set `DB_HOST=127.0.0.1` in `.env` |
| `Target class not found` | Run `composer dump-autoload` |
| `View not found` | Check `resources/views/tasks/` folder exists |
| `Nothing to migrate` | Your migration file may be missing — run `php artisan make:migration create_tasks_table` |
| Tests fail with DB errors | Add `DB_CONNECTION=sqlite` and `DB_DATABASE=:memory:` to `phpunit.xml` |

---

*Built for Qtec Solution Limited Technical Assessment — 2026*
