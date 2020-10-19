# Automatically bind Eloquent models as route segment variables

[![Latest stable release][version-badge]][link-packagist]
[![Software license][license-badge]](LICENSE.md)
[![Build status][travis-badge]][link-travis]
[![Total downloads][downloads-badge]][link-packagist]
[![Total stars][stars-badge]][link-github]

[![Read my blog][blog-link-badge]][link-blog]
[![View my other packages and projects][packages-link-badge]][link-packages]
[![Follow @sebastiaanluca on Twitter][twitter-profile-badge]][link-twitter]
[![Share this package on Twitter][twitter-share-badge]][link-twitter-share]

**Immediately start using models in your routes without having to worry about maintaining any list or map.**

Medium to large Laravel applications can have *a lot* of models. If you're a heavy user of [route model binding](https://laravel.com/docs/5.6/routing#route-model-binding) to automatically retrieve and inject model instances in your controllers, that means you have to *manually* register dozens or hundreds of models in your route service provider. You then need to do the same for each new, changed, or deleted model which makes this nifty feature hard to maintain and easy to forget.

This package solves the issue of manually having to register each model by doing all the grunt work for you. It reads your `composer.json` PSR-4 autoload section and scans all their model directories for usable Eloquent models. It then explicitly binds each model into the router as a route segment variable using a case type of your choosing (see [configuring casing](#casing)).

### Example

Get rid of this boilerplate code:

```php
public function boot() : void
{
    Route::model('user', \App\Users\User::class);
    Route::model('order', \App\Orders\Order::class);
    Route::model('shoppingCart', \App\Carts\Cart::class);
    Route::model('Item', \App\Item::class);
    Route::model('Admin', \App\Users\Admin::class);
    … (repeat dozens of times)
}
```

And just do this (for any Eloquent model in your application):

```php
Route::get('profile/{user}', ShowProfile::class);
Route::get('orders/{order}', ShowOrder::class);
Route::get('carts/{shoppingCart}', ShowShoppingCart::class);
…
```

## Table of contents

- [Requirements](#requirements)
- [How to install](#how-to-install)
- [How to use](#how-to-use)
    - [Defining model namespaces](#defining-model-namespaces)
    - [Route segment variables](#route-segment-variables)
    - [Caching bindings for production](#caching-bindings-for-production)
    - [Configuration](#configuration)
        - [Casing](#casing)
- [License](#license)
- [Change log](#change-log)
- [Testing](#testing)
- [Contributing](#contributing)
- [Security](#security)
- [Credits](#credits)
- [About](#about)

## Requirements

- PHP 7.3 or higher
- Laravel 7.0 or higher

## How to install

Via Composer:

```bash
composer require sebastiaanluca/laravel-route-model-autobinding
```

## How to use

### Defining model namespaces

Laravel route model autobinding uses your `composer.json` PSR-4 autoload section to know which namespaces and paths to scan. In any new Laravel project, the default `App\\` namespace is already in place, so for most projects no additional setup required. If you have other namespaces registered like local modules or (dev) packages, those will be scanned too.

```json
{
    "autoload": {
        "psr-4": {
            "App\\": "app/",
            "MyModule\\": "modules/MyModule/",
            "MyPackage\\": "MyPackage/src/"
        }
    }
}
```

Furthermore it filters out traits, abstract classes, helper files, and other unusable items to only bind valid Eloquent models.

### Route segment variables

After installing the package, you can immediately get to work using the aliased Eloquent models in your routes:

```php
Route::get('profile/{user}', ShowProfile::class);
Route::get('orders/{order}', ShowOrder::class);
Route::get('carts/{shoppingCart}', ShowShoppingCart::class);
…
```

Besides scanning and aliasing your models for you, this package alters no native Laravel functionality. Therefore, see the Laravel documentation on how to use [route model injection](https://laravel.com/docs/5.6/routing#route-model-binding).

### Caching bindings in production

To cache all bindings and speed up your application in production, add the cache command to your deploy scripts:

```
php artisan autobinding:cache
```

This scans all your current models and writes a static cache file to the `bootstrap/cache` directory. Upon subsequent framework booting, it reads the cache file instead of scanning and aliasing on-the-fly.

Note that this thus **disables runtime scanning**, meaning new models will not be recognized and changes to existing models will not be reflected (not very handy during development). You can however still change the case type in the configuration file, as the binding happens in a later stage.

To clear the cache file, run:

```
php artisan autobinding:clear
```

### Configuration

Run

```
php artisan vendor:publish
```

and select 

```
laravel-route-model-autobinding (configuration)
```

to publish the configuration file.

#### Casing

By default, the case type for aliasing models is set to *camel case*. You can change this to use camel, snake, or studly casing.

See `\SebastiaanLuca\RouteModelAutobinding\CaseTypes` for possible options.

Camel case (default):

```php
Route::get('carts/{shoppingCart}', ShowShoppingCart::class);
```

Snake case:

```php
Route::get('carts/{shopping_cart}', ShowShoppingCart::class);
```

Studly case:

```php
Route::get('carts/{ShoppingCart}', ShowShoppingCart::class);
```

The case type can still be changed after caching your models.

## License

This package operates under the MIT License (MIT). Please see [LICENSE](LICENSE.md) for more information.

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

```bash
composer install
composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE OF CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email [hello@sebastiaanluca.com][link-author-email] instead of using the issue tracker.

## Credits

- [Sebastiaan Luca][link-github-profile]
- [All Contributors][link-contributors]

## About

My name is Sebastiaan and I'm a freelance back-end developer specializing in building custom Laravel applications. Check out my [portfolio][link-portfolio] for more information, [my blog][link-blog] for the latest tips and tricks, and my other [packages][link-packages] to kick-start your next project.

Have a project that could use some guidance? Send me an e-mail at [hello@sebastiaanluca.com][link-author-email]!

[version-badge]: https://img.shields.io/packagist/v/sebastiaanluca/laravel-route-model-autobinding.svg?label=stable
[license-badge]: https://img.shields.io/badge/license-MIT-informational.svg
[travis-badge]: https://img.shields.io/travis/sebastiaanluca/laravel-route-model-autobinding/master.svg
[downloads-badge]: https://img.shields.io/packagist/dt/sebastiaanluca/laravel-route-model-autobinding.svg?color=brightgreen
[stars-badge]: https://img.shields.io/github/stars/sebastiaanluca/laravel-route-model-autobinding.svg?color=brightgreen

[blog-link-badge]: https://img.shields.io/badge/link-blog-lightgrey.svg
[packages-link-badge]: https://img.shields.io/badge/link-other_packages-lightgrey.svg
[twitter-profile-badge]: https://img.shields.io/twitter/follow/sebastiaanluca.svg?style=social
[twitter-share-badge]: https://img.shields.io/twitter/url/http/shields.io.svg?style=social

[link-github]: https://github.com/sebastiaanluca/laravel-route-model-autobinding
[link-packagist]: https://packagist.org/packages/sebastiaanluca/laravel-route-model-autobinding
[link-travis]: https://travis-ci.org/sebastiaanluca/laravel-route-model-autobinding
[link-twitter-share]: https://twitter.com/intent/tweet?text=Automatically%20bind%20Eloquent%20models%20as%20route%20segment%20variables.%20Via%20@sebastiaanluca%20https://github.com/sebastiaanluca/laravel-route-model-autobinding
[link-contributors]: ../../contributors

[link-portfolio]: https://www.sebastiaanluca.com
[link-blog]: https://blog.sebastiaanluca.com
[link-packages]: https://packagist.org/packages/sebastiaanluca
[link-twitter]: https://twitter.com/sebastiaanluca
[link-github-profile]: https://github.com/sebastiaanluca
[link-author-email]: mailto:hello@sebastiaanluca.com
