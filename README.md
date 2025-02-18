# Laravel Shop Application with Admin Panel

## Overview
This Laravel-based shop application provides:
- A **RESTful API** for product listing, creation, updating, and deletion.
- An **admin panel** built with Laravel Jetstream and Livewire for managing products and orders.
- A **clean architecture** using the Repository Pattern and Service Layer, following **SOLID principles**.
- **Unit tests** to ensure high code quality and maintainability.

## Features
- **Product API**: List, view, create, update, and delete products.
- **Admin Panel**: Manage products and view orders using Livewire components.
- **Clean Code Architecture**: Repositories for data access and services for business logic.
- **Test Coverage**: Unit tests for the service layer.
- **Documentation**: Detailed setup instructions and API documentation.

## Setup Instructions

### 1. Clone the Repository
```bash
git clone https://github.com/yourusername/laravel-shop.git
cd laravel-shop
```

### 2. Install Dependencies
```bash
composer install
npm install
npm run dev
```

### 3. Environment Configuration
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database Setup
```bash
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database/database.sqlite
touch database/database.sqlite
php artisan migrate
```

### 5. Run the Application
```bash
php artisan serve
```

### 6. Run Tests
```bash
php artisan test
```

## API Documentation

### Endpoints

#### 1. List All Products
**GET** `/api/products`
- Returns all products in JSON format.

#### 2. Get Product Details
**GET** `/api/products/{id}`
- Returns product details for the given ID.

#### 3. Create a Product
**POST** `/api/products`

**Request Body:**
```json
{
  "name": "Product Name",
  "description": "Product Description",
  "price": 99.99,
  "stock_quantity": 10
}
```
- Returns the newly created product.

#### 4. Update a Product
**PUT** `/api/products/{id}`

**Request Body (partial or full update):**
```json
{
  "name": "Updated Name",
  "price": 89.99
}
```
- Returns a success message.

#### 5. Delete a Product
**DELETE** `/api/products/{id}`
- Returns a success message.

## Development Methodology

### Architecture
- **Repository Pattern**: Separates data access logic (`ProductRepository`) from business logic.
- **Service Layer**: Encapsulates business rules and utilizes repositories.
- **SOLID Principles**:
  - Each class has a single responsibility.
  - Dependencies are injected.
  - Code is open for extension but closed for modification.

### Testing
- Unit tests for service methods ensure code reliability.

### Admin Panel
- Built with Jetstream & Livewire for product and order management.

### Error Handling
- Uses Laravel’s validation and exception handling to provide meaningful HTTP responses.

## Assumptions & Design Decisions
- The **product management functionality** is the core focus; cart and order management follow similar patterns.
- The **repository and service layers** allow easy swapping of data sources or additional business rules.
- The **admin panel** is secured using Jetstream’s authentication features.
- The **codebase follows modern PHP practices** with clear inline documentation.

## Additional Notes
- Extend the application by adding controllers and services for **cart** and **order management**.
- Use middleware (e.g., `AdminMiddleware`) to restrict admin routes as needed.
- Inline PHPDoc comments are added to classes and methods for clarity.

## Conclusion
This complete solution demonstrates how to build a Laravel shop application that:

- Uses the **Repository Pattern** with a **Service Layer** to separate concerns.
- Follows **SOLID principles** and other design patterns.
- Provides both a **RESTful API** and an **admin panel** using Jetstream/Livewire.
- Includes improved **test coverage** and comprehensive **documentation** for setup and development.

If I had more time I would implement more endpoints (e.g., for cart and order management), more unit tests, and refining the admin interface as needed. I would also improve validation and include attributes across all classes and functions.