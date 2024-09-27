# Support Ticket System

## Installation

### 1. Clone the Repository 

Clone the repository to your local machine:

### 2. Install Dependencies

```bash
composer install
npm install
npm run build
```

### 3. Set Up Environment Variables

cp .env.example .env

DB_DATABASE=your_database <br />
DB_USERNAME=your_username <br />
DB_PASSWORD=your_password <br /><br />

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME="${APP_NAME}"
ADMIN_EMAIL=

### 4. Migrating Database

```bash
php artisan migrate
```

```bash
php artisan db:seed
```

### 5. Accessing the Application

```bash
php artisan serve
```

Navigate to http://127.0.0.1:8000/ in your web browser.
Then register a customer and login.

Login  as Admin user using below credentials:<br />
Email: admin@gmail.com <br />
Password: 123456