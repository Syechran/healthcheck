# HealthCheck — API Reference

Complete reference for the HealthCheck backend API.
For setup / how to run, see **[Backend_Guide.md](Backend_Guide.md)**.

- **Base URL:** `http://127.0.0.1:8000/api`
- **Format:** JSON in, JSON out
- **Auth:** JWT (`Authorization: Bearer <access_token>`)

---

## Table of contents

1. [Conventions](#1-conventions)
2. [Authentication model](#2-authentication-model)
3. [Common errors](#3-common-errors)
4. [Data models](#4-data-models)
5. [Endpoints](#5-endpoints)
   - [POST /register](#post-apiregister)
   - [POST /login](#post-apilogin)
   - [POST /refresh](#post-apirefresh)
   - [POST /logout](#post-apilogout)
   - [GET /me](#get-apime)
   - [GET /detections](#get-apidetections)
   - [POST /detections](#post-apidetections)
   - [GET /detections/{id}](#get-apidetectionsid)
   - [DELETE /detections/{id}](#delete-apidetectionsid)
6. [Endpoint summary](#6-endpoint-summary)

---

## 1. Conventions

**Required request headers**

| Header          | Value                       | When                          |
| --------------- | --------------------------- | ----------------------------- |
| `Accept`        | `application/json`          | always (forces JSON errors)   |
| `Content-Type`  | `application/json`          | when sending a JSON body      |
| `Authorization` | `Bearer <access_token>`     | on protected endpoints        |

For file uploads (`POST /detections` with an image) use
`Content-Type: multipart/form-data` instead of JSON.

**Success status codes**

| Code  | Meaning                          |
| ----- | -------------------------------- |
| `200` | OK                               |
| `201` | Created (register)               |
| `204` | No Content (logout, delete)      |

Single resources are wrapped in a `data` key; lists add `links` + `meta`
(pagination).

---

## 2. Authentication model

JWT via `php-open-source-saver/jwt-auth`.

1. **Obtain a token** from `POST /register` or `POST /login`. The response
   contains `access_token` (the JWT), `token_type: "bearer"`, and `expires_in`
   (seconds; default **3600** = 60 minutes).
2. **Use it** on every protected request:
   ```
   Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...
   ```
3. **Refresh** before it expires with `POST /refresh` — returns a new token and
   blacklists the old one.
4. **Logout** with `POST /logout` — blacklists the current token immediately.

A token that is missing, malformed, expired, blacklisted (after logout/refresh),
or belongs to a deleted user yields `401 Unauthorized`.

---

## 3. Common errors

All errors are JSON.

**401 Unauthorized** — missing/invalid/expired token:
```json
{ "message": "Unauthenticated." }
```

**403 Forbidden** — authenticated, but the resource isn't yours:
```json
{ "message": "This action is unauthorized." }
```

**404 Not Found** — no record with that id:
```json
{ "message": "Record not found." }
```

**422 Unprocessable Entity** — validation failed. `errors` maps each field to its
messages:
```json
{
  "message": "The email field is required. (and 1 more error)",
  "errors": {
    "email": ["The email field is required."],
    "password": ["The password field is required."]
  }
}
```

**429 Too Many Requests** — exceeded the rate limit on `/register` or `/login`
(6/min per IP). Includes a `Retry-After` header.

---

## 4. Data models

### User

| Field        | Type     | Notes                  |
| ------------ | -------- | ---------------------- |
| `id`         | integer  |                        |
| `name`       | string   |                        |
| `email`      | string   | unique                 |
| `created_at` | datetime | ISO-8601 (UTC)         |

### Detection

| Field            | Type            | Notes                                              |
| ---------------- | --------------- | -------------------------------------------------- |
| `id`             | integer         |                                                    |
| `disease_name`   | string          | the (dummy) detected illness                       |
| `severity`       | string enum     | `mild` \| `moderate` \| `severe`                   |
| `severity_label` | string          | Indonesian label: `Ringan` \| `Sedang` \| `Berat`  |
| `confidence`     | integer 0–100   | match percentage                                   |
| `detected_area`  | string \| null  | e.g. `telinga`, `wajah`                            |
| `image_url`      | string \| null  | public URL if a photo was uploaded                 |
| `notes`          | string \| null  | free text                                          |
| `detected_at`    | datetime        | when the detection happened                        |
| `created_at`     | datetime        |                                                    |

### Severity values

| Value (API) | Label (returned) |
| ----------- | ---------------- |
| `mild`      | `Ringan`         |
| `moderate`  | `Sedang`         |
| `severe`    | `Berat`          |

---

## 5. Endpoints

### POST /api/register

Create an account and receive a JWT. **Public.** Rate-limited 6/min/IP.

**Body**

| Field                   | Rules                                          |
| ----------------------- | ---------------------------------------------- |
| `name`                  | required, string, max 255                      |
| `email`                 | required, email, lowercase, unique, max 255    |
| `password`              | required, confirmed, Laravel default strength  |
| `password_confirmation` | required, must match `password`                |
| `device_name`           | optional, string                               |

```json
{
  "name": "Budi",
  "email": "budi@example.com",
  "password": "rahasia123",
  "password_confirmation": "rahasia123"
}
```

**Response `201 Created`**
```json
{
  "user": { "id": 3, "name": "Budi", "email": "budi@example.com", "created_at": "2026-05-23T05:40:00.000000Z" },
  "access_token": "eyJ0eXAiOiJKV1Q...",
  "token_type": "bearer",
  "expires_in": 3600
}
```

**Errors:** `422` (validation, e.g. email already taken), `429` (rate limit).

---

### POST /api/login

Exchange credentials for a JWT. **Public.** Rate-limited 6/min/IP.

**Body**

| Field         | Rules                  |
| ------------- | ---------------------- |
| `email`       | required, email        |
| `password`    | required, string       |
| `device_name` | optional, string       |

```json
{ "email": "wowo@example.com", "password": "password" }
```

**Response `200 OK`**
```json
{
  "user": { "id": 1, "name": "Wowo", "email": "wowo@example.com", "created_at": "2026-05-23T05:36:54.000000Z" },
  "access_token": "eyJ0eXAiOiJKV1Q...",
  "token_type": "bearer",
  "expires_in": 3600
}
```

**Errors:** `422` (wrong email/password → `{"errors":{"email":["Email atau kata sandi salah."]}}`), `429`.

---

### POST /api/refresh

Issue a new JWT from the current (still-valid) one; the old token is blacklisted.
**Auth required.**

**Response `200 OK`** — same envelope as login (new `access_token`).

**Errors:** `401` (missing/expired/already-blacklisted token).

---

### POST /api/logout

Invalidate the current JWT. **Auth required.**

**Response `204 No Content`** (empty body). Reusing the token afterward → `401`.

---

### GET /api/me

The authenticated user plus profile stats (used by the Profil screen).
**Auth required.**

**Response `200 OK`**
```json
{
  "user": { "id": 1, "name": "Wowo", "email": "wowo@example.com", "created_at": "2026-05-23T05:36:54.000000Z" },
  "stats": { "detections": 2, "months_active": 1, "consultations": 0 }
}
```

| Stat            | Meaning                                          |
| --------------- | ------------------------------------------------ |
| `detections`    | total detections owned by the user               |
| `months_active` | whole months since the account was created (≥ 1) |
| `consultations` | always `0` (placeholder; no consultation feature) |

---

### GET /api/detections

Paginated detection history for the **authenticated user only**, newest first.
**Auth required.**

**Query params**

| Param  | Type | Notes                          |
| ------ | ---- | ------------------------------ |
| `page` | int  | page number (15 items / page)  |

**Response `200 OK`**
```json
{
  "data": [
    {
      "id": 1,
      "disease_name": "Dermatitis",
      "severity": "mild",
      "severity_label": "Ringan",
      "confidence": 90,
      "detected_area": "telinga",
      "image_url": null,
      "notes": null,
      "detected_at": "2026-05-23T05:36:54.000000Z",
      "created_at": "2026-05-23T05:36:54.000000Z"
    }
  ],
  "links": { "first": "...?page=1", "last": "...?page=1", "prev": null, "next": null },
  "meta": { "current_page": 1, "from": 1, "last_page": 1, "per_page": 15, "to": 2, "total": 2 }
}
```

**Errors:** `401`.

---

### POST /api/detections

Create a detection record for the authenticated user. **Auth required.**
Accepts JSON, or `multipart/form-data` when uploading an `image`.

**Body**

| Field           | Rules                                                  |
| --------------- | ------------------------------------------------------ |
| `disease_name`  | **required**, string, max 255                          |
| `severity`      | optional, one of `mild` \| `moderate` \| `severe` (default `mild`) |
| `confidence`    | optional, integer 0–100 (default `0`)                  |
| `detected_area` | optional, string, max 255                              |
| `image`         | optional, image file, max 5 MB (multipart only)        |
| `notes`         | optional, string, max 2000                             |

`detected_at` is set to the current time by the server.

```json
{ "disease_name": "Eksim", "severity": "moderate", "confidence": 83, "detected_area": "tangan", "notes": "uji coba" }
```

**Response `200 OK`**
```json
{
  "data": {
    "id": 3,
    "disease_name": "Eksim",
    "severity": "moderate",
    "severity_label": "Sedang",
    "confidence": 83,
    "detected_area": "tangan",
    "image_url": null,
    "notes": "uji coba",
    "detected_at": "2026-05-23T05:37:29.000000Z",
    "created_at": "2026-05-23T05:37:29.000000Z"
  }
}
```

**Errors:** `401`, `422` (e.g. missing `disease_name`, bad `severity`, image > 5 MB).

---

### GET /api/detections/{id}

Fetch a single detection **by its id**. **Auth required.** You may only fetch
**your own** detections.

**Path params**

| Param | Type | Notes                  |
| ----- | ---- | ---------------------- |
| `id`  | int  | the detection's id     |

**Response `200 OK`**
```json
{
  "data": {
    "id": 1,
    "disease_name": "Dermatitis",
    "severity": "mild",
    "severity_label": "Ringan",
    "confidence": 90,
    "detected_area": "telinga",
    "image_url": null,
    "notes": null,
    "detected_at": "2026-05-23T05:36:54.000000Z",
    "created_at": "2026-05-23T05:36:54.000000Z"
  }
}
```

**Errors:** `401`, `403` (someone else's detection), `404` (no such id).

---

### DELETE /api/detections/{id}

Delete one of **your own** detections by id. **Auth required.**

**Response `204 No Content`** (empty body).

**Errors:** `401`, `403` (not the owner), `404` (no such id).

---

## 6. Endpoint summary

| Method | Endpoint               | Auth | Success | Description                          |
| ------ | ---------------------- | ---- | ------- | ------------------------------------ |
| POST   | `/api/register`        | —    | `201`   | Create account → user + JWT          |
| POST   | `/api/login`           | —    | `200`   | Log in → user + JWT                  |
| POST   | `/api/refresh`         | ✓    | `200`   | Get a fresh JWT (old one blacklisted)|
| POST   | `/api/logout`          | ✓    | `204`   | Invalidate the current JWT           |
| GET    | `/api/me`              | ✓    | `200`   | Current user + profile stats         |
| GET    | `/api/detections`      | ✓    | `200`   | Paginated history (own records)      |
| POST   | `/api/detections`      | ✓    | `200`   | Create a detection                   |
| GET    | `/api/detections/{id}` | ✓    | `200`   | Get one detection by id (owner only) |
| DELETE | `/api/detections/{id}` | ✓    | `204`   | Delete a detection by id (owner only)|

---

## Appendix — full walkthrough

### PowerShell

```powershell
$base = "http://127.0.0.1:8000/api"
$H = @{ Accept = "application/json" }

# Log in -> JWT
$login = Invoke-RestMethod "$base/login" -Method Post -Headers $H -Body @{ email="wowo@example.com"; password="password" }
$auth  = @{ Accept="application/json"; Authorization="Bearer $($login.access_token)" }

# Profile + stats
Invoke-RestMethod "$base/me" -Headers $auth

# History
Invoke-RestMethod "$base/detections" -Headers $auth

# Create, then fetch by id
$new = Invoke-RestMethod "$base/detections" -Method Post -Headers $auth -Body @{ disease_name="Eksim"; severity="moderate"; confidence=83 }
Invoke-RestMethod "$base/detections/$($new.data.id)" -Headers $auth

# Delete by id
Invoke-RestMethod "$base/detections/$($new.data.id)" -Method Delete -Headers $auth
```

### curl

```bash
BASE=http://127.0.0.1:8000/api

# Log in and capture the JWT
TOKEN=$(curl -s -X POST $BASE/login \
  -H "Accept: application/json" \
  -d "email=wowo@example.com&password=password" | jq -r .access_token)

# Authenticated calls
curl -s $BASE/me            -H "Accept: application/json" -H "Authorization: Bearer $TOKEN" | jq
curl -s $BASE/detections    -H "Accept: application/json" -H "Authorization: Bearer $TOKEN" | jq
curl -s $BASE/detections/1  -H "Accept: application/json" -H "Authorization: Bearer $TOKEN" | jq

# Create
curl -s -X POST $BASE/detections \
  -H "Accept: application/json" -H "Authorization: Bearer $TOKEN" \
  -d "disease_name=Eksim&severity=moderate&confidence=83" | jq

# Upload a photo (multipart)
curl -s -X POST $BASE/detections \
  -H "Accept: application/json" -H "Authorization: Bearer $TOKEN" \
  -F "disease_name=Dermatitis" -F "image=@./foto.jpg" | jq
```
