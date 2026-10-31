# Client Management API

Laravel backend for the Client Management System. Provides CRUD operations for
clients and calculates service charge, discount value and final project value
automatically.

## Tech Stack

- Laravel 12
- PHP 8.2
- MySQL
- nwidart/laravel-modules

## Setup

1. Clone the repository

2. Install dependencies
   composer install

3. Create the environment file
   copy .env.example .env

4. Generate the application key
   php artisan key:generate

5. Create a MySQL database named `client_management`

6. Update the database settings in .env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=client_management
   DB_USERNAME=root
   DB_PASSWORD=

7. Run the migrations
   php artisan migrate

8. The API base url is
   http://localhost/client-management-backend/public/api

## API Endpoints

| Method | Endpoint | Description |
| --- | --- | --- |
| GET | /api/clients/getalldata | Get all clients |
| POST | /api/clients/storeclient | Add a new client |
| PUT | /api/clients/updateclient | Update phone, address and project budget |
| DELETE | /api/clients/deleteclient?id= | Delete a client |
| GET | /api/clients/searchbyphone?phone= | Search clients by phone number |

## Calculation Rules

Service Charge, based on the project budget

| Project Budget | Service Charge |
| --- | --- |
| 1,000,000 and above | Project Budget * 10% |
| 500,000 to 999,999 | Project Budget * 5% |
| Below 500,000 | Project Budget * 2% |

Discount Value, based on the number of employees

| Number Of Employees | Discount |
| --- | --- |
| More than 100 | Project Budget * 5% |
| Less than 100 | Project Budget * 2% |
| Not given or exactly 100 | 0 |

Final Project Value = Project Budget + Service Charge - Discount Value

These values are calculated when a client is created and calculated again when
the project budget is updated.

## Architecture

The project uses the Repository Pattern with Laravel Modules.

Modules/ClientManagement/
  app/
    Models/Client.php
    Repositaries/ClientInterface.php
    Repositaries/ClientImplementation.php
    Http/Requests/AddClientRequest.php
    Http/Requests/UpdateClientRequest.php
    Http/Controllers/ClientManagementController.php
  database/migrations/
  routes/api.php

The controller depends on ClientInterface instead of the implementation class.
The interface is bound to ClientImplementation in app/Providers/AppServiceProvider.php,
so the database logic can be changed without changing the controller.

The three calculations are written as private methods inside the implementation
class, so the same logic is used by both the store and the update methods.

## Assumptions

1. Number Of Employees field

   The discount rule depends on how many employees a company has, but this field
   is not listed in the Add Client fields in the specification. A nullable
   no_of_employees field was added to the clients table and to the Add Client
   form. If it is left blank the discount becomes 0, which matches the
   "Otherwise Discount = 0" rule in the specification.

2. Client reports

   The specification lists the fields a client report should include, and these
   are the same fields listed under View All Clients. The View All Clients table
   displays all nine fields, so it is used as the client report.

## Author

Sarah M.D.
