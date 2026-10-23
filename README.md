# SakayLocal — Angelie Pardillo

SakayLocal is a community transit companion for Bohol. Its friendly, green interface helps passengers find local terminals, check verified fares, and join a queue before traveling. Administrators manage transit data and approve queue requests.

## Features

- Register, log in, log out, and load the current user with Laravel Sanctum bearer tokens
- Passenger and administrator roles, with admin controls hidden in React and enforced by Laravel middleware
- Full create, read, update, and delete workflows for terminals and fare routes
- Search and status filters with Laravel API pagination
- Dashboard summaries for active terminals, approved routes, queue requests, and pending requests
- Queue ticket workflow: Pending → Approved → Completed, with passenger cancellation for pending tickets
- Client and server validation, field-level error messages, loading states, success/error feedback, and delete confirmation
- Responsive layouts for desktop and mobile

## Tech stack

- React 18, Vite, React Router, Axios, functional components and hooks
- Plain responsive CSS
- Laravel 12, PHP 8.2+, Sanctum API tokens, Form Requests, API Resources
- MySQL/MariaDB schema via Laravel migrations and seeders
- Composer, npm, Git; use Postman or Thunder Client to explore the JSON API

## Requirements

- PHP 8.2+, Composer, and MySQL or MariaDB
- Node.js 20.19+ and npm
- Git

## Setup

1. Create a MySQL database named `sakaylocal` (or use the checked-in local SQLite configuration).
2. In `backend`, copy `.env.example` to `.env`, set `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD`, then run:

   ```sh
   composer install
   php artisan key:generate
   php artisan migrate --seed
   php artisan serve
   ```

The API runs at `http://127.0.0.1:8000/api`. `backend/.env.example` is configured for MySQL/MariaDB. The local ignored `backend/.env` uses SQLite for a quick demo.

Seeded accounts:

| Role | Email | Password |
| --- | --- | --- |
| Admin | `admin@sakaylocal.test` | `password` |
| Passenger | `user@sakaylocal.test` | `password` |

The seeder creates 22 terminals, 22 connected fare routes, and sample queue tickets. Do not use these demo passwords outside a local development environment.

## Run the frontend

In a second terminal, in `frontend`, copy `.env.example` to `.env` if you need a custom API URL, then install and start Vite:

```sh
npm install
npm run dev
```

The frontend uses `http://localhost:8000/api` by default. CORS allows the Vite development origins; set `CORS_ALLOWED_ORIGINS` in the backend environment when using a different frontend origin.

## API documentation

All protected endpoints require `Authorization: Bearer <token>` and `Accept: application/json`.

| Method | Endpoint | Access | Purpose / parameters |
| --- | --- | --- | --- |
| POST | `/api/auth/register` | Public | Register passenger (`name`, `email`, `password`, `password_confirmation`); returns user and token (201) |
| POST | `/api/auth/login` | Public | Login (`email`, `password`); returns user and token |
| GET | `/api/auth/me` | Authenticated | Current user and role |
| POST | `/api/auth/logout` | Authenticated | Revoke current token (204) |
| GET | `/api/dashboard` | Authenticated | Database summary counts; queue figures are scoped to the passenger unless admin |
| GET | `/api/terminals` | Authenticated | Search/filter/page: `search`, `status`, `page`, `per_page` |
| POST | `/api/terminals` | Admin | Create terminal (`name`, `place`, `status`, `wait_minutes`, `capacity`) (201) |
| GET / PUT / DELETE | `/api/terminals/{id}` | Authenticated / Admin / Admin | View / update / delete terminal (delete returns 204) |
| GET | `/api/fare-routes` | Authenticated | Eager-loaded origin/destination; search/filter/page: `search`, `status`, `page`, `per_page` |
| POST | `/api/fare-routes` | Admin | Create route (`origin_terminal_id`, `destination_terminal_id`, `fare`, `status`) (201) |
| GET / PUT / DELETE | `/api/fare-routes/{id}` | Authenticated / Admin / Admin | View / update / delete fare route (delete returns 204) |
| GET | `/api/queue-entries` | Authenticated | Passenger sees own tickets; admin sees all. Filter by `search` and `status`; paginated |
| POST | `/api/queue-entries` | Authenticated | Join a terminal queue (`terminal_id`) (201) |
| GET / PATCH / DELETE | `/api/queue-entries/{id}` | Owner or Admin | View ticket; update valid status; delete pending ticket (204) |

Validation failures return 422 with field errors; unauthenticated requests return 401; role/ownership failures return 403; missing records return 404. Queue transitions are `pending → approved → completed`; owners can cancel their pending ticket.

## ERD and presentation

- Database relationship diagram: [`docs/erd.png`](docs/erd.png) ([SVG source](docs/erd.svg))
- Project presentation: [`docs/presentation.pdf`](docs/presentation.pdf)
- Main page captures: [`docs/screenshots/README.md`](docs/screenshots/README.md)

