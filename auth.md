# 🔐 Authentication & Authorization

This document outlines how authentication and authorization would be structured in this API using Laravel’s built-in tools.

---

## ✅ Authentication

Authentication is handled using **Laravel Sanctum**, a simple token-based system suitable for SPAs and mobile APIs.

### 🔑 Login Endpoint

The user can authenticate by making a `POST` request to the following endpoint:

```
POST /api/sanctum/token
```

### Request Body

```json
{
  "email": "user@example.com",
  "password": "password"
}
```

### Successful Response

```json
{
  "token": "plain-text-api-token"
}
```

### Usage

All protected endpoints must include the `Authorization` header:

```
Authorization: Bearer <plain-text-api-token>
```

---

## 🔒 Authorization

Authorization is managed using **Laravel Policies**, which offer granular access control to resources like `Event`.

### Example Policy Logic

Each model (e.g., `Event`) has a policy class (e.g., `EventPolicy`) with methods to define access rules:

```php
public function update(User $user, Event $event)
{
    return $user->id === $event->user_id;
}
```

### Enforcement in Controller

```php
$this->authorize('update', $event);
```

Laravel will automatically throw a `403 Forbidden` error if the authorization fails.

---

## Summary

- 🔐 Auth tokens issued via Sanctum
- 🔐 Bearer tokens used in `Authorization` header
- 🔐 Policies restrict access to only authorized users
- 🔐 All sensitive endpoints require authentication

