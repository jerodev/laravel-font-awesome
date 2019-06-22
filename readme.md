# Font Awesome Blade directives for Laravel
[![Build Status](https://travis-ci.com/jerodev/laravel-font-awesome.svg?branch=master)](https://travis-ci.com/jerodev/laravel-font-awesome) [![StyleCI](https://github.styleci.io/repos/193088933/shield?branch=master)](https://github.styleci.io/repos/193088933)

> Work In Progress

- [Requirements](#requirements)
- [Installation](#installation)
  - [Service provider](#service-provider)
- [Usage](#usage)
  - [Middleware](#middleware)
- [Configuration](#configuration)

## Requirements

- PHP 7.2+
- Laravel 5.6+

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

The order of scanning is `regular`, `brands`, `solid`.

### Middleware

This package includes a middleware that injects a minimal stylesheet into your views on render. By default, this middleware is added to the `web` middleware group. 

If you don't want to have the style injected automatically, you can disable `middleware.all_requests` in the [configuration](#configuration). In this case, you will have to add the middleware to selected routes yourself or add your own CSS.

The middleware you should use is `\Jerodev\LaraFontAwesome\Middleware\InjectStyleSheet::class`.


## Configuration

The package contains a few configuration options that can be modified by first publishing the config file using the command below. This will create a `fontawesome.php` file in your `config` folder.

    php artisan vendor:publish --provider="Jerodev\LaraFontAwesome\FontAwesomeServviceProvider"
    
| Key  | Type | Default value | Description |
| --- | --- | --- | --- |
| `Middelware.all_requests` | boolean  | `true` |  |
