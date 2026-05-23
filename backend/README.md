# HealthCheck — Backend API

Laravel 13 + PostgreSQL REST API for the HealthCheck illness-detection app.
**JWT authentication** (`php-open-source-saver/jwt-auth`). Two domain tables:
**users** and **detections** (the detection history). Detection results are dummy
data — there is no real ML model behind them.

📖 **Full docs (in the project root):**
- [`../Backend_Guide.md`](../Backend_Guide.md) — setup & how to run
- [`../Backend_API_Guide.md`](../Backend_API_Guide.md) — complete API reference

## Requirements

- PHP 8.3+ with extensions: `pdo_pgsql`, `pgsql`, `mbstring`, `openssl`, `curl`, `fileinfo`, `zip`, `sodium`
- Composer 2
- PostgreSQL 16+ (developed against 18)

## Quick start

```powershell
composer install

# create the database (as the postgres superuser)
& "C:\Program Files\PostgreSQL\18\bin\psql.exe" -U postgres -h 127.0.0.1 -c "CREATE DATABASE healthcheck;"

# on a fresh clone only:
# copy .env.example .env ; php artisan key:generate ; php artisan jwt:secret

php artisan migrate --seed
php artisan storage:link
php artisan serve            # http://127.0.0.1:8000
```

`.env` is preconfigured for PostgreSQL:

```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=healthcheck
DB_USERNAME=postgres
DB_PASSWORD=postgres123
JWT_SECRET=<php artisan jwt:secret>
```

> Dev-only credentials. Change `DB_PASSWORD` and regenerate `JWT_SECRET` for
> anything real. The `backend/database/setup_postgres.sql` script can create a
> dedicated DB user instead of using the `postgres` superuser.

## Demo account (after seeding)

| Email               | Password   |
| ------------------- | ---------- |
| `wowo@example.com`  | `password` |

## Endpoints

| Method | Endpoint               | Auth | Description                          |
| ------ | ---------------------- | ---- | ------------------------------------ |
| POST   | `/api/register`        | —    | Create account → user + JWT          |
| POST   | `/api/login`           | —    | Log in → user + JWT                  |
| POST   | `/api/refresh`         | ✓    | Get a fresh JWT                      |
| POST   | `/api/logout`          | ✓    | Invalidate the current JWT           |
| GET    | `/api/me`              | ✓    | Current user + profile stats         |
| GET    | `/api/detections`      | ✓    | Paginated history (own records)      |
| POST   | `/api/detections`      | ✓    | Create a detection                   |
| GET    | `/api/detections/{id}` | ✓    | Get one detection by id (owner only) |
| DELETE | `/api/detections/{id}` | ✓    | Delete a detection by id (owner)     |

Protected routes need `Authorization: Bearer <access_token>`.
See [`../Backend_API_Guide.md`](../Backend_API_Guide.md) for full request/response
details.
