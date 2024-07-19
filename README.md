# Ledger App

This is a Laravel-based ledger application that allows users to register, create accounts, manage balances, and perform transactions. Below are the API endpoints currently available in the application.

## API Endpoints

### 1. User Registration

**Endpoint:** `POST /api/register`

**Request Body:**
```json
{
    "name": "John Doe",
    "email": "johndoe@example.com",
    "password": "secret12342"
}
```
### 2. Create a New Account

**Endpoint:** `POST /api/accounts/create-account`

**Request Body:**
```json
{
    "user_id": 1,
    "account_name": "Investment Account",
    "account_type": "investment"
}
```

### 3. Add Balance to Account

**Endpoint:** `POST /api/add-balance`

**Request Body:**
```json
{
    "account_id": 1,
    "amount": 200
}
```

### 4. Get User Accounts

**Endpoint:** `POST /api/accounts/get-user-accounts`

**Request Body:**
```json
{
    "user_id": 1,
}
```

### 5. Send Credit

**Endpoint:** `POST /api/send-credit`

**Request Body:**
```json
{
    "from_account_id": 1,
    "to_account_id": 2,
    "amount": 10,
    "description": "debt",
    "transaction_type": "Transfer"
}
```

### 6. Withdraw from Account

**Endpoint:** `POST /api/withdraw`

**Request Body:**
```json
{
    "account_id": 2,
    "amount": 300
}
```

### 7. Get Balance at a Specific Date

**Endpoint:** `POST /api/accounts/balance-at-date`

**Request Body:**
```json
{
    "user_id": 1,
    "account_id": 2,
    "date": "2024-07-09 04:05:15"
}
```

## Installation

1. Clone the repository:
    ```sh
    git clone https://github.com/yourusername/ledger-app.git
    ```
2. Navigate to the project directory:
    ```sh
    cd ledger-app
    ```
3. Install dependencies:
    ```sh
    composer install
    npm install
    ```
4. Set up the environment file:
    ```sh
    cp .env.example .env
    ```
5. Generate an application key:
    ```sh
    php artisan key:generate
    ```
6. Run database migrations:
    ```sh
    php artisan migrate
    ```
7. Serve the application:
    ```sh
    php artisan serve
    ```

## License

This project is licensed under the MIT License.