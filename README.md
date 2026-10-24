# EcoBuddy – Eco-Facility Web App

A web application for finding and managing eco-facilities such as recycling centres, community gardens and green technology hubs. Built for the Client Server Systems module at the University of Salford.

Users can search facilities with a live search, filter them by category and see them on an interactive map. Managers can add, edit and delete facilities.

## Features

- **Live search:** results appear as you type, using AJAX requests to a PHP endpoint that returns JSON.
- **Category filter and pagination:** search by title and category, with results split into pages.
- **Interactive map:** facilities are shown as markers on a Leaflet map (OpenStreetMap tiles), loaded from a JSON endpoint. The map also shows your own location if you allow it.
- **Facility management:** managers can add, edit and delete facilities, with a duplicate-title check.
- **Login and roles:** users log in with a username and password. Only managers (user type 1) can see the add, edit and delete options.
- **Sessions:** inactive users are logged out after 15 minutes.

## Technologies

- PHP 8 (MVC structure, PDO)
- SQLite
- JavaScript (AJAX with XMLHttpRequest and fetch, JSON)
- HTML, CSS and Bootstrap
- Leaflet and OpenStreetMap

## Security and validation

- Passwords are stored as bcrypt hashes.
- All database queries use prepared statements.
- Search input is checked on both the browser and the server (letters, numbers and spaces, 1–30 characters).
- Coordinates are validated before they are saved or shown on the map.
- Output is escaped with `htmlspecialchars` to help prevent cross-site scripting.

## Project structure

```
Models/      Database connection and data classes (EcoFacility, EcoFacilityDataSet and so on)
Views/       Page templates (.phtml files)
css/         Stylesheets
js/          liveSearch.js and map.js
database/    SQLite database (sample data only)
*.php        Controllers and endpoints (index, login, add, edit, delete, search, fetch)
```

## Database

The SQLite database has these tables: `ecoFacilities`, `ecoCategories`, `ecoFacilityStatus`, `ecoUser` and `ecoUsertypes`. The data in this repository is sample data and does not contain real users.

## How to run it

1. Install PHP 8 or later with the `pdo_sqlite` extension enabled.
2. Download or clone this repository.
3. In a terminal, go to the project folder and run:
   ```
   php -S localhost:8000
   ```
4. Open `http://localhost:8000` in your browser.

You can also place the folder inside the `htdocs` folder of XAMPP and open it through Apache.

## Test accounts

| Username | Password | Role |
| --- | --- | --- |
| admin | G7!fY8mZ$2k@PwR4  | admin
| lee | H7k@M2!jXwY9r&Lp  | User |

## Author

Ravi Eyongo – BSc (Hons) Computer Science with Cyber Security, University of Salford
