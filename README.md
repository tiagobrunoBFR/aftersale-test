## About Project

- Test Aftersale

## Mental map
 
- **[ http://www.xmind.net/m/5SBsgD]( http://www.xmind.net/m/j8WC9G)** 

## Tools
 
 - **[Laravel Framework](https://laravel.com/)** version 8

## Documentation

 In the root directory of the project there is the <b>documentation.json</b> file, that can be imported by insominia, for more information look the documentation **[link](https://support.insomnia.rest/article/52-importing-and-exporting-data)**

## Config Project

You need to configure the .env file steps

- 1 config in env variables shopify
<br />
SHOPIFY_PASSWORD=4e788173c35d04421ab4793044be622f
<br />
SHOPIFY_BASE_URL=https://send4-avaliacao.myshopify.com/admin/api/2021-01/
 
- 2 config MAIL_USERNAME and MAIL_PASSWORD to send email (I used **[https://mailtrap.io/inboxes](https://mailtrap.io/inboxes)**)
- 3 config QUEUE_CONNECTION (I used database)
- 4 config your database in .env


## Run Project

- composer install 
- php artisan jwt:secret 
- php artisan key:generate
- php artisan config:clear
- php artisan migrate
- php artisan serve
## Run Queue
- php artisan queue:work

## Run Tests

- php artisan test
