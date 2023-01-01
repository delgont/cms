
# Delgont CMS

## Installation

#### # Requirements
`Composer` `Laravel Framework 6.0+`


#### # Installing Delgont CMS via composer

After you have installed the core requirements for delgont, you may install it via composer. To get started add `delgont/cms` to the list of required packages in your `composer.json` file.

```php
"require": {
        "php": "^7.2",
        "laravel/framework": "^6.0",
        "laravel/helpers": "^1.5",
        "laravel/passport": "^9.3.2",
        "laravel/tinker": "^1.0",
        "delgont/cms": "^1.0",
        "delgont/ui" : "^1.0"
    },
```

After your `composer.json` file has been updated, run the `composer update` command in your console terminal.

```php
composer update
```

Alternatively you can install delgont cms by simply running `composer` `require` `delgont/cms` command in you console terminal.

```php
composer require delgont/cms
```


## Setting Up

#### # Publish assets and configuration files
```php
php artisan delgont:install
```
#### # Setup delgont database tables
```php
php artisan migrate
```
#### # Create Admin user
```php
php artisan delgont:user --create
```
#### # Access the application dashoard
```composer
https://delgont.com/dashoard
```
## Configurations

#### # Web Configuration File

The `config\web` configuration file holds the configuration options that are use to create content for your content delivery application. In here is where you define your core page keys, post types and categories etc

`Default Page Keys`

```php
'pages' => [
    'home', 'about-us', 'services', 'contact-us', 'gallery', 'team'
],
```
`Default Post Types`

```php
'post_types' => [
    'latest news', 'team member', 'service'
],
```

`Default Categories`

```php
 'categories' => [
        'latest news', 'sports', 'team member', 'etc'
    ],
```
 
#### # Customization

You can customise delgont CMS by changing the options in `config\delgont` configuration file.

```php
# Route prefix for accessing the admin panel for dlegont cms -- default dashboard
'route_prefix' => 'dashboard',
```
```php
# You can add additional middlewares - to protect your CMS application
'middlewares' => ['web', 'auth', 'etc'],
 ```

 #### # Quick Commands

`php artisan delgont:install --fresh` `php artisan migrate:fresh` `php artisan delgont:user --create --default` `php artisan page:sync --fresh` `php artisan posttype:sync` `php artisan category:sync`

## License

The Delgont CMS Package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).




