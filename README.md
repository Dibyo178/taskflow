# TaskFlow

A task management system built for the Qtec Solution Limited Full Stack Laravel Developer assessment. The application enables teams to create, organize, and track daily work through a clean dashboard interface with status progression, priority levels, and deadline management.

**Live Demo:** https://taskflow.sourovdev.space

---

## Technologies Used

| Layer | Technology |
|---|---|
| Language | PHP 8.2+ |
| Framework | Laravel 11 |
| Templating | Blade |
| Styling | Vanilla CSS with CSS custom properties |
| Database | MySQL 8 |
| ORM | Eloquent |
| Testing | PHPUnit (via Laravel) |
| Typography | Syne + DM Sans (Google Fonts) |

No front-end build tools (Node.js, Vite, Webpack) are required. The project runs with Composer alone.

---

## Setup Instructions

### Requirements

- PHP 8.2 or higher
- Composer 2.x
- MySQL 8.x
- Git

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

**3. Create the environment file**

```bash
cp .env.example .env
php artisan key:generate
```

**4. Configure the database**

Open `.env` and set your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=taskflow
DB_USERNAME=root
DB_PASSWORD=
```

Create a database named `taskflow` in MySQL before the next step.

**5. Run migrations**

```bash
php artisan migrate
```

**6. Seed demo data** *(optional)*

```bash
php artisan db:seed
```

This inserts 18 sample tasks across different statuses and priorities so the dashboard is populated immediately.

**7. Start the development server**

```bash
php artisan serve
```

Visit **http://127.0.0.1:8000** in your browser.

---

## Running Tests

Open a **second terminal window** while `php artisan serve` is running in the first, then execute:

```bash
php artisan test
```

**Expected output:**

```
PASS  Tests\Unit\StoreTaskRequestTest
PASS  Tests\Unit\TaskModelTest
PASS  Tests\Feature\TaskControllerTest

Tests: 23 passed
```

---

## Assumptions and Decisions

**No authentication**
The brief described a task management system for a team — not a multi-user platform with individual accounts. Authentication was excluded to stay within the assessed scope. Laravel Breeze could be added with minimal changes if user ownership is required.

**Vanilla CSS over a framework**
Tailwind CSS and Bootstrap both require a Node.js compilation step. Using plain CSS with custom properties means the project runs with `composer install` alone — no additional tooling, no build step, no version conflicts.

**Form Request classes for validation**
Input validation lives in `StoreTaskRequest` and `UpdateTaskRequest` rather than inline in the controller. This keeps the controller thin, makes the validation rules explicit, and allows them to be tested independently without going through HTTP.

**Business logic on the model**
Computed properties such as `isOverdue` and query scopes such as `scopeOverdue` are defined on the `Task` model. Centralizing logic here avoids duplication across controllers and views, and makes it straightforward to test in isolation.

**File-based session and cache drivers**
The default Laravel configuration uses database-backed sessions and cache, which requires additional migration tables. These were switched to `file` to reduce setup friction. For a production deployment with multiple servers, a shared driver such as Redis would be more appropriate.

---

## Testing Approach

The test suite is organized into three layers.

**Feature tests — `tests/Feature/TaskControllerTest.php`**

These tests dispatch real HTTP requests through the full application stack and assert on responses and database state. They cover the complete task lifecycle: listing with filters and search, creating, viewing, editing, quick-status patching via PATCH, and deletion. Edge cases such as 404 responses for missing records and validation rejections are also covered.

**Model unit tests — `tests/Unit/TaskModelTest.php`**

These tests exercise the `Task` model directly, without involving routes or controllers. They verify that query scopes return the correct records, that the `isOverdue` accessor behaves correctly across different status and date combinations, that badge class accessors return the expected CSS class strings, and that the `due_date` field is cast to a Carbon instance.

**Validation unit tests — `tests/Unit/StoreTaskRequestTest.php`**

These tests instantiate the `StoreTaskRequest` form request class and run the Laravel validator against a range of inputs. Covered cases include the required title field, enum constraints on status and priority, and the rejection of past due dates. Testing validation this way avoids the overhead of full HTTP dispatching while still exercising the exact rules the application enforces.

The rationale for this structure is that each layer catches a distinct class of bug. Validation errors surface in unit tests, model logic errors surface in model tests, and integration errors surface in feature tests — making failures faster to locate and fix.
