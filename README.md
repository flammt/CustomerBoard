# Customer Board

## Installation

- Clone repository
- Run `composer install` in root dir
- Run `npm install` (in root dir)
- (Run `npm audit fix`)
- Create `.env` file (from example)
- Run `php artisan key:generate`
- Change `.env/DB_*` details to your database
- Create database (`customerboard`)
- Create role (`customerboard`)
- Grant rights `ALL` to role on schema `public`
- Run `php artisan migrate`
- (Run `php artisan db:seed` for some dummy data)
- Make your webserver point to the `public` directory
- Run `npm run production`

Browse to the base url. 
With a local installation with virtual host this could be 
`http://customerboard` and you should be redirected to `http://customerboard/login`.
