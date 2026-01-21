# Simple E-commerce Shopping Cart

## Overview
A simple e-commerce shopping cart system where  Users should  browse products, add them to a cart, update quantities, and remove items. The application utilizes:

- **Laravel** as the  framework FullStack
- **Tailwind CSS** for styling
- **Livewire** as the Starterkit

## Features
- Browsing of Products
- Adding a product to Cart
- Increasing and Decreasing of unit both at a product page and cart
- Removing Product from the cart both at a product page and cart
- Unit testing with PHPUnit

## Project Setup
### Prerequisites
Ensure you have the following installed:
- Node.js (>= 18)
- npm or yarn
- PHP >= 8.1
- Composer
- Laravel 12
- MySQL / PostgreSQL

### Installation
Clone the repository:
```sh
git clone https://github.com/kimbugweronnie/SimpleE-commerceShoppingCart.git
cd SimpleE-commerceShoppingCart
```

Install  PHP dependencies:

```sh
composer install
```
Install  Frontend dependencies:

```sh
 npm install
```
### Configuration

```sh
# Copy example environment file
 cp .env.example .env
```

```sh
# Copy example environment file
php artisan key:generate
 ```
### Database Setup

```sh
# Run migrations
php artisan migrate
 ```
```sh
# The products are seeded into the database.So this is a MUST
php artisan db:seed
 ```
### Running the Project

```sh
# Start the Laravel development server
php artisan serve
 ```

```sh
# Start Vite for asset compilation
npm run dev
 ```


## Contributing
1. Fork the repository
2. Create a feature branch (`git checkout -b feature-branch`)
3. Commit your changes (`git commit -m "Add new feature"`)
4. Push to the branch (`git push origin feature-branch`)
5. Open a Pull Request

## License
This project is licensed under the MIT License.

---
