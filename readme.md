## Agaru Store
Agaru store is grocery store with cashless payment. In our milestones, we want to make everybody easy to shop without any queue to pay the bill.
Video link here : https://drive.google.com/file/d/1masVzMgiR34REcY8EjCWwWLa8c3kZZXi/view?usp=sharing

## Requirements
1. Barcode number using EAN-13
2. PHP 5.6+
3. MySql
4. Laravel 5.8

## How to Use this API?
Clone this repo

## First to do
1. `composer install`
2.  Setup your MySql DB
3.  Setup your DB in `.env` file, copy `.env.example` if not exist
4. `php artisan key:generate`
5. `php artisan migrate`
6. `php artisan db:seed`

We are not provide Product and Product Category creation, in case you want to create another product just do with Laravel Tinker
1. `php artisan tinker`

<b> Product Creation </b>
```
$product = new \App\Product();
$product->name = 'product_name';
$product->price = 50000;
$product->category_id = 1;
$product->ean_number = rand(pow(10, 13-1), pow(10, 13)-1);
$product->ean_number_img_path = '/storage/public/ean/upto_u_ean.png'
```

<b> Product Category Creation </b>
```
$productCat = new \App\ProductCategory();
$productCat->name = 'product_name';
$productCat->slug = 'up_to_u_but_unique';
```

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
