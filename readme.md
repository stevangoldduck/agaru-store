Clone this repo

## First to do
1. `composer install`
2.  Setup your DB in `.env` file, copy `.env.example` if not exist
3. `php artisan migrate`
4. `php artisan db:seed`

## API Documentation Table

<b> Auth </b>
Type | Endpoint | Parameter | Description | Auth
------------ | ------------ | ------------- | ------------- | -------------
POST | api/register | email (required) <br> password (required) <br> name (required) | Register your account | No
POST | api/login | email (required) <br> password (required) | Use this endpoint to get token as your Authorization credential | No

<b> User </b>
Type | Endpoint | Parameter | Description | Auth
------------ | ------------ | ------------- | ------------- | -------------
POST | api/profile | api_token (required) | Get your profile info | Yes
POST | api/topup/me | api_token (required) <br> amount (required)  | Topup your balance account | Yes
GET | api/profile/topup-history | api_token (required) | Get collection of user's topup history | Yes
GET | api/cart | api_token (required) | Get user's current cart | Yes

<b> Products </b>
Type | Endpoint | Parameter | Description | Auth
------------ | ------------ | ------------- | ------------- | -------------
GET | api/products | - | Get user's current cart | Yes

<b> Order </b>
Type | Endpoint | Parameter | Description | Auth
------------ | ------------ | ------------- | ------------- | -------------
POST | api/add/item | ean_number (required) <br> qty (required) <br> api_token (required) | Add product item to cart with ean number from product | Yes
POST | api/checkout | order_barcode (required) <br> api_token (required) | Checkout user cart | Yes
