# City REST API (Laravel)

Basic Laravel CRUD REST API that manages a City resource entirely in memory (PHP array). No database is used; data resets when the app restarts or when tests re-seed the repository.

## Requirements
- PHP 8.2+
- Composer

## Setup
1. Install dependencies: `composer install`
2. Copy env (created automatically by Composer): ensure `.env` exists.
3. Run the API server: `php artisan serve`
4. Base URL defaults to `http://127.0.0.1:8000`.

## Endpoints
- GET `/api/cities` — list seeded cities
- POST `/api/cities` — create a city (`name`, `country`, `population`)
- GET `/api/cities/{id}` — fetch a city
- PUT `/api/cities/{id}` — update a city
- DELETE `/api/cities/{id}` — remove a city

Example create payload:
```json
{
	"name": "Dire Dawa",
	"country": "Ethiopia",
	"population": 440000
}
```

## Tests
Run the feature suite: `php artisan test`
Tests reset the in-memory store before each case for predictable results.

## Notes
- Storage lives only in memory; restarting the server restores the seeded sample data.
- Validation ensures `name` and `country` are strings and `population` is a non-negative integer.
