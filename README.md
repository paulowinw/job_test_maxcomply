# Quick start

## Commands to setup the project

### Install all project dependencies (while prompeted, default option can be accepted)
```
composer install
```
### Create the database (if it doesn't exist)
```
php bin/console doctrine:database:create
php bin/console doctrine:database:create --env=test
```
### Run the database migrations to create the tables (while prompeted, default option can be accepted)
```
php bin/console doctrine:migrations:migrate
php bin/console doctrine:migrations:migrate --env=test
```
### Example data can be found in 
```
database_example_data.sql
```
### Example CURL request (Consider the AUTH token hardcoded on configs)
```
curl --location 'http://localhost:8000/api/vehicles/1' \
--header 'X-AUTH-TOKEN: my-secret-token'
```


# Critical endpoints that would be add and why

Here are the critical endpoints I would add and why:

- POST /api/vehicles (Create a new Vehicle):

Purpose: Allows the creation of a new vehicle entry.

Why it's critical: Without this, the system is read-only. A dynamic system needs to be able to add new data.

Behavior: Accepts a JSON body with all vehicle details and returns the newly created vehicle object with its ID. It should be an authenticated endpoint (e.g., ROLE_ADMIN).

- DELETE /api/vehicles/{id} (Delete a Vehicle):

Purpose: Removes a vehicle from the database.

Why it's critical: Data lifecycle management. Vehicles can become obsolete, or entries might be erroneous. This allows for data cleanup.

Behavior: Accepts a vehicle ID and returns a 204 No Content response on success. This should also be a highly restricted endpoint, likely for ROLE_ADMIN only.

- POST /api/makers (Create a new Vehicle Maker):

Purpose: Allows the addition of a new manufacturer.

Why it's critical: Vehicles must be linked to a maker. Before adding a vehicle from a new manufacturer, the manufacturer itself needs to be created.

Behavior: Accepts a JSON body with the maker's name. Returns the newly created maker.

- GET /api/vehicles (Retrieve all Vehicles):

Purpose: Lists all vehicles in the system.

Why it's critical: Provides an overview and a starting point for discovering individual vehicle details. It's often paired with pagination and filtering options (e.g., ?limit=10&page=2, ?maker=Ford).

- GET /api/makers (Retrieve all Makers):

Purpose: Lists all vehicle makers.

Why it's critical: Similar to the above, this provides a way to discover available makers.

These endpoints, combined with the initial three, would create a robust and standard CRUD-based REST API that is both functional and maintainable.




# Description of the challenge

## MaxComply Backend Code Challenge

### Objective
Using a known PHP framework, your assignment is to implement a backend REST API.

### Brief
Start by designing a SQL database structure which can store technical data about vehicles (i.e. top speed, dimensions, engine data, type ) and their make.

Create a REST API for accessing the data, focusing on the following three endpoints: 
1. Endpoint for retrieving all the vehicle makers which are manufacturing a specific type of vehicle
2. Endpoint for retrieving all the technical details of a specific vehicle
3. Endpoint for updating a specific technical parameter of a vehicle

Write the relevant Unit Tests.

Comment what other endpoints you consider critical for a standard REST API implementation.

### Tasks
Implement the assignment using:
- language: PHP
- framework: Symfony or Laravel 
- testing libraries: PHPUnit

### Expected Behaviour
- The exposed endpoints will return standard REST responses
- Only authorised request will be served. Unauthorised requests should be declined

### Extra Notes
- Limit to 10 the number of the technical parameters considered for a vehicle

### Evaluation Criteria
- OOP / MVC / SOLID best practices
- Following the REST API standards
- Show your work through commit history
- Demonstrate how you design a SQL database
- Implementing highly reusable code
- Completeness: Did you complete the features?
- Correctness: Does the functionality act in sensible, thought-out ways?
- Maintainability: Is it written in a clean, maintainable way?
- Testing: Is the system adequately tested?

## Delivery
Please provide a link to a git/bitbucket repository which contains the application code.

## Contact
If you encounter any issues or have any questions you can contact:
- Mihai: mihai.craciun@iqeq.com
- Marian: marian.dobre@iqeq.com
