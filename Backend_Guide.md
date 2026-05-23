# HealthCheck — Backend Guide

Backend for the **HealthCheck** illness-detection app.
**Stack:** Laravel 13 · PHP 8.3+ · PostgreSQL · **JWT auth** (`php-open-source-saver/jwt-auth`).

> For the complete endpoint-by-endpoint API reference (request bodies, validation
> rules, every response), see **[Backend_API_Guide.md](Backend_API_Guide.md)**.

The backend lives in [`backend/`](backend/) and exposes a JSON REST API with two
domain tables:

- **users** — accounts (register / login / logout / refresh, profile stats)
- **detections** — each user's detection history (the "Riwayat" screen)

> Detection results are **dummy data** — there is no real ML model. The API just
> stores and returns whatever result is submitted (disease name, severity,
> confidence, etc.).

---

## 1. Prerequisites

| Tool          | Version          | Check            |
| ------------- | ---------------- | ---------------- |
| PHP           | 8.3 or newer     | `php -v`         |
| Composer      | 2.x              | `composer -V`    |
| PostgreSQL    | 13 or newer      | `psql --version` |

**Required PHP extensions:** `pdo_pgsql`, `pgsql`, `mbstring`, `openssl`, `curl`,
`fileinfo`, `zip`, `sodium`. Check with `php -m`. Enable any missing ones in your
`php.ini` (uncomment the matching `extension=...` line) — `sodium` is needed by
the JWT library.

**Installing the toolchain (pick your OS):**

- **Windows** — PHP from [windows.php.net](https://windows.php.net/download/)
  (Non-Thread-Safe x64), Composer from [getcomposer.org](https://getcomposer.org/),
  PostgreSQL from [enterprisedb.com](https://www.postgresql.org/download/windows/).
  All-in-one alternatives: [Laragon](https://laragon.org/) or [XAMPP](https://www.apachefriends.org/).
- **macOS** — `brew install php composer postgresql` (or [Laravel Herd](https://herd.laravel.com/)).
- **Linux (Debian/Ubuntu)** — `sudo apt install php8.3-cli php8.3-pgsql php8.3-mbstring php8.3-curl php8.3-zip composer postgresql`.

> Only the **PHP CLI** is required — Laravel's built-in server (`php artisan serve`)
> handles HTTP. You do **not** need Apache or Nginx for local development.

---

## 2. First-time setup

Run these from the `backend/` folder.

```bash
cd backend

# 1. Install PHP dependencies
composer install

# 2. Create your environment file and app key
cp .env.example .env            # Windows PowerShell: copy .env.example .env
php artisan key:generate
php artisan jwt:secret           # generates JWT_SECRET used to sign tokens
```

### 2a. Configure the database connection

Edit `backend/.env` and set the PostgreSQL values for your machine:

```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=healthcheck
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

### 2b. Create the database

Create an empty database named `healthcheck` (any one of these works):

```bash
# Option A — createdb helper
createdb -U your_db_user healthcheck

# Option B — psql one-liner
psql -U your_db_user -h 127.0.0.1 -c "CREATE DATABASE healthcheck;"
```

> **Optional — dedicated DB user.** Instead of using a superuser, you can create a
> least-privilege user. A ready-made script lives at
> [`backend/database/setup_postgres.sql`](backend/database/setup_postgres.sql);
> run it once as the postgres superuser, then set `DB_USERNAME`/`DB_PASSWORD`
> accordingly.

### 2c. Build the schema and seed demo data

```bash
php artisan migrate --seed
php artisan storage:link          # serve uploaded detection photos
```

---

## 3. Running the server

```bash
php artisan serve
```

API base URL: **`http://127.0.0.1:8000/api`**
(override with `php artisan serve --host=0.0.0.0 --port=8080`).

Reset the database at any time:

```bash
php artisan migrate:fresh --seed
```

### Demo account (created by the seeder)

| Email              | Password   |
| ------------------ | ---------- |
| `wowo@example.com` | `password` |

Seeded with two detections (Dermatitis · Jerawat) so the history screen has data.

---

## 4. Authentication (JWT)

1. `POST /api/register` or `POST /api/login` → returns `access_token` (a JWT).
2. Send it on every protected request:

   ```
   Authorization: Bearer <access_token>
   Accept: application/json
   ```

3. `POST /api/refresh` swaps a still-valid token for a fresh one (the old one is
   blacklisted).
4. `POST /api/logout` invalidates the current token.

Tokens expire after **60 minutes** (`config/jwt.php` → `ttl`). Always send
`Accept: application/json` so errors come back as JSON (`401` / `422`).

---

## 5. API at a glance

Base URL: `http://127.0.0.1:8000/api` · **Auth** ✓ = JWT `Bearer` token required.

| Method | Endpoint               | Auth | Description                               |
| ------ | ---------------------- | ---- | ----------------------------------------- |
| POST   | `/register`            | —    | Create account → user + token             |
| POST   | `/login`               | —    | Log in → user + token                     |
| POST   | `/refresh`             | ✓    | Get a fresh token                         |
| POST   | `/logout`              | ✓    | Invalidate the current token (`204`)      |
| GET    | `/me`                  | ✓    | Current user + profile stats              |
| GET    | `/detections`          | ✓    | Paginated history (own records, 15/page)  |
| POST   | `/detections`          | ✓    | Create a detection record                 |
| GET    | `/detections/{id}`     | ✓    | Get one detection by id (owner only)      |
| DELETE | `/detections/{id}`     | ✓    | Delete a detection by id (owner only)     |

`/register` and `/login` are **rate-limited** to 6 requests/min per IP.
Full request/response details: **[Backend_API_Guide.md](Backend_API_Guide.md)**.

### Quick smoke test

```bash
# Log in and capture the JWT
TOKEN=$(curl -s -X POST http://127.0.0.1:8000/api/login \
  -H "Accept: application/json" \
  -d "email=wowo@example.com&password=password" | jq -r .access_token)

# List history
curl -s http://127.0.0.1:8000/api/detections \
  -H "Accept: application/json" -H "Authorization: Bearer $TOKEN" | jq
```

---

## 6. Troubleshooting

| Symptom | Fix |
| ------- | --- |
| `could not find driver` (pgsql/sqlite) | Enable `extension=pdo_pgsql` and `extension=pgsql` in `php.ini`; ensure `DB_CONNECTION=pgsql`; then `php artisan config:clear`. |
| `password authentication failed` | Check `DB_USERNAME` / `DB_PASSWORD` in `.env` match your PostgreSQL login. |
| `database "healthcheck" does not exist` | Create it (step 2b). |
| Token errors / no `JWT_SECRET` | Run `php artisan jwt:secret`. |
| `ext-sodium` missing during `composer install` | Enable `extension=sodium` in `php.ini`. |
| `php`/`composer` not recognized | Add them to your `PATH` and open a new terminal. |
| Validation returns HTML, not JSON | Send the `Accept: application/json` header. |
| Config/route changes ignored | `php artisan config:clear` and `php artisan route:clear`. |

---

## 7. Project structure

```
backend/
  app/
    Enums/Severity.php                       mild | moderate | severe (+ labels)
    Http/Controllers/Api/AuthController.php   JWT register/login/logout/refresh/me
    Http/Controllers/Api/DetectionController.php
    Http/Requests/Auth/{Register,Login}Request.php
    Http/Requests/StoreDetectionRequest.php
    Http/Resources/{User,Detection}Resource.php
    Models/{User,Detection}.php              User implements JWTSubject
    Policies/DetectionPolicy.php             owner-only view/delete
  config/
    auth.php                                 'api' guard => driver "jwt"
    jwt.php                                  JWT settings (ttl, algo, blacklist)
  database/
    migrations/...create_detections_table.php
    factories/DetectionFactory.php
    seeders/DatabaseSeeder.php               demo user "Wowo" + dummy history
    setup_postgres.sql                       optional: dedicated DB user
  routes/api.php                             all API routes (auth:api)
  .env                                       your local configuration
```
