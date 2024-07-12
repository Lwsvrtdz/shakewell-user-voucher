# User Registration API
This application is built using Laravel 11.x utilizes Mailtrap for Email engine
## Overview
This project is a User Registration API built with Laravel. It allows users to register with a unique username, first name, password, and email address. Upon successful registration, a welcome email containing a unique voucher code is sent to the user. Authenticated users can generate, view, and delete their own voucher codes, with a limit of 10 codes per user.

## Features
- User Registration with unique username and email.
- Welcome email with a unique voucher code upon registration.
- Authenticated users can:
  - Generate unique voucher codes.
  - View their own voucher codes.
  - Delete their own voucher codes.
- Limit of 10 voucher codes per user.
- Basic error handling.
- Basic Laravel access control.
- Adherence to SOLID and DRY principles.

## Installation
1. Clone the repository:
```
git clone https://github.com/your-repo/shakewell-user-voucher.git
cd shakewell-user-voucher
```

2. Install dependencies:
```
composer install
```

3. Copy the `.env.example` to `.env` and configure your environment variables:
```
cp .env.example .env
```
4. Generate application key:
```
php artisan key:generate
```
5. Set up your database and run migrations:
```
php artisan migrate
```
6. Set up your mail configuration in the `.env` file:
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=from@example.com
MAIL_FROM_NAME="${APP_NAME}"


# Running Tests

To run the tests using PHPUnit, you can use the following Artisan command:
```
php artisan test
```
