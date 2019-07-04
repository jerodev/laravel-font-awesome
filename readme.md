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

- PHP >= 7.1.3
- Laravel >= 5.6

## Installation

Install the package using [Composer](https://getcomposer.org/).

    composer require jerodev/laravel-font-awesome

### Service Provider

The package will be auto-discovered by Laravel. If you disabled auto-discovery, you should add the following provider to your `config/app.php` file.

    \Jerodev\LaraFontAwesome\FontAwesomeServviceProvider::class,

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

This package includes a middleware that injects a minimal stylesheet into your views on render. By default, this middleware is added to the `web` middleware group.

If you don't want to have the style injected automatically, you can disable `middleware.all_requests` in the [configuration](#configuration). In this case, you will have to add the middleware to selected routes yourself or add your own CSS.

The middleware you should use is `\Jerodev\LaraFontAwesome\Middleware\InjectStyleSheet::class`.


## Configuration

The package contains a few configuration options that can be modified by first publishing the config file using the command below. This will create a `fontawesome.php` file in your `config` folder.

    php artisan vendor:publish --provider="Jerodev\LaraFontAwesome\FontAwesomeServiceProvider"

| Key  | Type | Default value | Description |
| --- | --- | --- | --- |
| `libraries` | string[]  | `['regular', 'brands', 'solid']` | The icon libraries that will be available. This is also the order in which the libraries will be searched for icons. |
| `middelware.all_requests` | boolean  | `true` | When enabled, the stylesheet needed for the icons will automatically be injected on every request returning html. |

## To Do

Currently the package only supports basic icon rendering. There is no support for special cases, such as: [stacking icons](https://fontawesome.com/how-to-use/on-the-web/styling/stacking-icons) or [masking icons](https://fontawesome.com/how-to-use/on-the-web/styling/masking), because I never used these myself.

In the future however, I want to add these as well to make this package support the full api that is available using the Font Awesome library.