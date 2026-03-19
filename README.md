# Personal Blog in PHP

A fully functional blog built using pure PHP (no frameworks), focused on understanding core web application architecture and internal mechanics.
## Features
- ✅ Custom routing system (built from scratch)
- ✅ Full CRUD for blog posts
- ✅ Rich text editor integration (Quill)
- ✅ Content sanitization before database persistence
- ✅ Protected admin panel
- ✅ Authentication system (login)
- ✅ Custom middleware implementation
- ✅ Database seeding for admin user
- ✅ Layered architecture (Domain, Controllers, etc.)

## Project Structure
```
├── core/            # Core infrastructure (e.g., HTTP handling)
├── public/          # Application entry point (index.php, assets)
├── queries/         # SQL scripts
├── scripts/         # Utility scripts (e.g., seed)
├── src/
│   ├── Controllers/ # Request handlers
│   ├── Data/        # Data manipulation layer
│   ├── Database/    # Database connection
│   ├── Domain/
│   │   ├── Models/        # Entities
│   │   └── Repositories/  # Data access logic
│   ├── Middlewares/ # Custom middleware layer
│   ├── Pages/       # Views / templates
│   ├── Router/      # Custom routing system
│   ├── Service/     # Business logic
│   └── Utils/       # Helper utilities
```

## Technologies

- PHP (no frameworks)
- SQLite (or compatible database)
- Quill.js (rich text editor)
- Bootstrap
- HTML, CSS, JavaScript

## Authentication

The application includes a protected admin area.

To create the admin user, run:

`php scripts/seed.php`

## Getting Started

Clone the repository:

`git clone https://github.com/your-username/your-repo.git`

Navigate to the project folder:

`cd your-repo`

Set up the database:

Create a database

Run the SQL scripts located in queries/

Configure database credentials (e.g., .env or config file)

Start the PHP development server:

`php -S localhost:8000 -t public`

Open in your browser:

[localhost:8000](http://localhost:8000)

## Architecture

The project follows a layered structure inspired by best practices:

Controllers → Handle incoming requests

Repositories → Data access layer

Models → Domain entities

Middlewares → Request filtering/interception

Router → Route definitions and handling

## Notes

This project was built for educational purposes

No frameworks were used intentionally

Some security and scalability improvements can be made for production use

## Key Learnings

This project covers important concepts such as:

- Building a router from scratch
- Implementing middleware without a framework
- Structuring a PHP application manually
- Basic security practices (input sanitization)
- Separation of concerns
