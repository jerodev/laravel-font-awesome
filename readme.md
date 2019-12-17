# Font Awesome Blade directives for Laravel
[![Latest Stable Version](https://poser.pugx.org/jerodev/laravel-font-awesome/v/stable?format=flat-square)](https://packagist.org/packages/jerodev/laravel-font-awesome)
[![License](https://poser.pugx.org/jerodev/laravel-font-awesome/license?format=flat-square)](https://packagist.org/packages/jerodev/laravel-font-awesome)
[![Travis (.com)](https://img.shields.io/travis/com/jerodev/laravel-font-awesome.svg?style=flat-square)](https://travis-ci.com/jerodev/laravel-font-awesome)
[![StyleCI](https://github.styleci.io/repos/193088933/shield?branch=master)](https://github.styleci.io/repos/193088933)
[![Scrutinizer code quality (GitHub/Bitbucket)](https://img.shields.io/scrutinizer/quality/g/jerodev/laravel-font-awesome/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/jerodev/laravel-font-awesome/?branch=master)

This package will render font awesome icons in your views on the server side. This removes the need to add extra JavaScript or webfont resources on the client side and in doing so reduces the size of your website significantly.

This is achieved by replacing the icons with their svg counterpart before sending the response to the client.

``` html
<!-- Turns this -->
@fas('circle')
  
<!-- Into this -->
<svg viewBox="0 0 512 512" class="svg-inline--fa fa-w-16 fa-circle">
    <path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"/>
</svg>
```

## Requirements

| Requirement | Version |
| --- | --- |
| PHP | >= 7.2 |
| Laravel | 6.x |

### Laravel 5.x

For Laravel 5.6 and up, use version v1.x of this package

## Installation

Install the package using [Composer](https://getcomposer.org/).

    composer require jerodev/laravel-font-awesome

### Service Provider

The package will be auto-discovered by Laravel. If you disabled auto-discovery, you should add the following provider to your `config/app.php` file.

    \Jerodev\LaraFontAwesome\FontAwesomeServiceProvider::class,

## Usage

To use Font Awesome icons in your view there are a few new blade directives.

``` php
// Let the package discover the best library for this icon.
@fa('laravel')

// Define the library that should be used.
@far('circle')      // Regular
@fas('circle')      // Solid
@fab('laravel')     // Brands
```

When using the `@fa()` directive. The package will scan the different Font Awesome libraries and use the first library where it finds the icon.

The order in which the libraries are scanned is `regular`, `brands`, `solid`. But this can be modified in the [configuration](#configuration).

### Middleware

> :warning: Since version 2.0, the middleware is no longer automatically injected. You will have to add this to the routes where needed.

This package includes a middleware, [`InjectStyleSheet`](src/Middleware/InjectStyleSheet.php), that injects a minimal stylesheet into your views on render.

The middleware can be added to your routes [as documented by Laravel](https://laravel.com/docs/master/middleware#assigning-middleware-to-routes):

```php
Route::middleware(InjectStyleSheet::class)->group(static function () {
    // Create routes here.
});
```

## Configuration

The package contains a few configuration options that can be modified by first publishing the config file using the command below. This will create a `fontawesome.php` file in your `config` folder.

    php artisan vendor:publish --provider="Jerodev\LaraFontAwesome\FontAwesomeServiceProvider"

| Key  | Type | Default value | Description |
| --- | --- | --- | --- |
| `libraries` | string[]  | `['regular', 'brands', 'solid']` | The icon libraries that will be available. This is also the order in which the libraries will be searched for icons. |
