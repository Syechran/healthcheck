-- Idempotent dev database + role setup for HealthCheck.
-- Run ONCE as the postgres superuser (it will prompt for the postgres password):
--
--   & "C:\Program Files\PostgreSQL\18\bin\psql.exe" -U postgres -h 127.0.0.1 -f "database/setup_postgres.sql"
--
-- Safe to re-run: it creates the role/database if missing, otherwise just
-- resets the dev password.

-- 1. Role: create if missing, else (re)set the password.
DO $$
BEGIN
  IF NOT EXISTS (SELECT FROM pg_roles WHERE rolname = 'healthcheck_user') THEN
    CREATE ROLE healthcheck_user LOGIN PASSWORD 'hcdev_2026_secret';
  ELSE
    ALTER ROLE healthcheck_user WITH LOGIN PASSWORD 'hcdev_2026_secret';
  END IF;
END
$$;

-- 2. Database: create only if it does not already exist.
SELECT 'CREATE DATABASE healthcheck OWNER healthcheck_user ENCODING ''UTF8'''
WHERE NOT EXISTS (SELECT FROM pg_database WHERE datname = 'healthcheck')\gexec

-- 3. Make sure the dev user can create tables in the public schema (PG 15+).
\connect healthcheck
GRANT ALL ON SCHEMA public TO healthcheck_user;
ALTER SCHEMA public OWNER TO healthcheck_user;
