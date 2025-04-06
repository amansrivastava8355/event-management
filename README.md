
# Event Booking API

A RESTful API for managing events and bookings using Laravel.

---

## 📦 Prerequisites

- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)

---

## 🚀 Getting Started

### 1. Start Docker Containers

```bash
docker-compose up -d
```

This will:
- Build and start the PHP with apache, and MySQL services
- Create network connections between containers
- Run in detached mode

---

### 2. Run Database Migrations

```bash
docker-compose exec --user www-data app bash -c "php artisan migrate:refresh"
```

This will:
- Run all database migrations
- Reset the database structure
- Use the `www-data` user for proper file permissions

---

### 3. (Optional) Seed Sample Data

```bash
docker-compose exec --user www-data app bash -c "php artisan db:seed"
```

---

### 4. Access the Application

The API will be available at:

```
http://localhost:8000
```

---

## ✅ Testing

### Run All Tests

```bash
docker-compose exec --user www-data app bash -c "php artisan test"
```

### Run a Booking Test

```bash
docker-compose exec --user www-data app bash -c "php artisan test --filter=BookingTest"
```
### Run a Attendees Test
```bash
docker-compose exec --user www-data app bash -c "php artisan test --filter=AttendeeTest"
```
### Run a Events Test
```bash
docker-compose exec --user www-data app bash -c "php artisan test --filter=EventTest"
```

### Generate Test Coverage Report

```bash
docker-compose exec --user www-data app bash -c "php artisan test --coverage-html=coverage"
```

The coverage report will be available in the `/coverage` directory.

---

## 🛠️ Useful Commands

### Check Container Status

```bash
docker-compose ps
```

### View Application Logs

```bash
docker-compose logs app
```

### Stop All Containers

```bash
docker-compose down
```

---

## 📘 API Documentation

After starting the containers, access the Swagger UI documentation at:

```
http://localhost:8000/api/documentation
```

---

## 🔐 Authentication & Authorization


You can find the complete authentication and authorization architecture in: auth.md
