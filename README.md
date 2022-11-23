<img align="left" alt="Delgont CMS" width="200px" src="https://raw.githubusercontent.com/delgont/cms/main/post.png" />
<br />
<br />



[![](https://raw.githubusercontent.com/delgont/delgont/main/cover.png)](ttps://www.linkedin.com/in/stephendev)

# Delgont CMS


## Installation

### # Requirements

There are a few requirements you should consider before installing delgont CMS.
- Composer
- Laravel Framework 6.0+
- NPM

### # Browser Support

Delgont supports modern versions of the following browsers:
- Apple Safari
- Google Chrome
- Microsoft Edge
- Mozilla Firefox

### # Installing Delgont CMS via composer

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

### # Finally

Finally, run the `delgont:install` artisan command. This command will install delgont's service provider, public assets and publish configuration files.

```php
php artisan delgont:install
```

```php
php artisan migrate
```
If you do not have a delgont admin user yet in your users table, you can add one by running the `delgont:user` command and follow the prompts.

```php
php artisan delgont:user --create
```
Next you may navigate to you applications `delgont.com/delgont` path in your browser and you should be presented with delgont dashboard or login page.

```composer
https://delgont.com/delgont
```

### # Configurations

#### Web Configuration File

The `config\web` configuration file holds the configuration options that are use to create content for your content delivery application. In here is where you define your core page keys, post types and categories etc

1. Default Page Keys

 Each page must have a unique key eg home, about-us, services, contact-us These page keys may be used as labels on the navigation menu, these can be edited later

```php
'pages' => [
    'home', 'about-us', 'services', 'contact-us', 'gallery', 'team'
],
```

2. Default Post Types

 Even though posts may be categorized futher, each post must belong to a specific type Post types can also be entered manually via the cms keeping in mind that they must belong to specific pages or categories

```php
'post_types' => [
    'latest news', 'team member', 'service'
],
```

3.  Default Categories -- used to categorise posts and any model that uses the Categorable trait

```php
 'categories' => [
        'latest news', 'sports', 'team member', 'etc'
    ],
```
 
### # Customization

You can customise delgont CMS by changing the options in `config\delgont` configuration file.

```php
# Route prefix for accessing the admin panel for dlegont cms -- default dashboard
'route_prefix' => 'dashboard',
```
```php
# You can add additional middlewares - to protect your CMS application
'middlewares' => ['web', 'auth', 'etc'],
 ```

 ## Quick Commands

 ```composer
php artisan delgont:install --fresh

php artisan migrate:fresh

php artisan delgont:user --create --default

php artisan page:sync --fresh

php artisan posttype:sync

php artisan category:sync
```



