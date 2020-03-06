# Font Awesome Blade component for Laravel
[![Latest Stable Version](https://poser.pugx.org/jerodev/laravel-font-awesome/v/stable)](https://packagist.org/packages/jerodev/laravel-font-awesome)
[![License](https://poser.pugx.org/jerodev/laravel-font-awesome/license)](https://packagist.org/packages/jerodev/laravel-font-awesome)
![PHP tests](https://github.com/jerodev/laravel-font-awesome/workflows/php%20tests/badge.svg)

> This version of the package only works with Laravel 7.x and up.<br />
> For other Laravel versions, refer to [version 2.0 of this package](readme_old.md).

This package will render font awesome icons in your views on the server side. This removes the need to add extra JavaScript or webfont resources on the client side and in doing so reduces the size of your website significantly.

This is achieved by injecting the icons as their svg counterpart before sending the rendered view to the client.

```html
<!-- Turns this -->
<x-fa name="circle"/>
  
<!-- Into this -->
<svg viewBox="0 0 512 512" class="svg-inline--fa fa-w-16 fa-circle">
    <path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"/>
</svg>
```

## Requirements

| Requirement | Version |
| --- | --- |
| PHP | >= 7.2.5 |
| Laravel | 7.x |

## Installation

Install the package using [Composer](https://getcomposer.org/).

    composer require jerodev/laravel-font-awesome

### Service Provider

The package will be auto-discovered by Laravel. If you disabled auto-discovery, you should add the following provider to your `config/app.php` file.

    \Jerodev\LaraFontAwesome\FontAwesomeServiceProvider::class,

## Usage

### Middleware

This package includes a middleware, [`InjectStyleSheet`](src/Middleware/InjectStyleSheet.php), that injects a minimal stylesheet into your views on render.

The middleware can be added to your routes [as documented by Laravel](https://laravel.com/docs/master/middleware#assigning-middleware-to-routes):

```php
Route::middleware(InjectStyleSheet::class)->group(static function () {
    // Create routes here.
});
```

### Rendering

This package uses the new [blade components](https://laravel.com/docs/7.x/blade#components) added in Laravel 7.
Using the `x-{component}` tags, the icons can be rendered, the name of the component can be changed in [the configuration](#configuration).

```html
<!-- Let the package discover the best library for this icon. -->
<x-fa name="laravel"/>

<!-- Let the package discover the best library for this icon. -->
<x-fa name="circle" library="regular"/>
<x-fa name="circle" library="solid"/>
<x-fa name="laravel" library="brand"/>
```

When using the `<x-fa>` component without the `library` attribute, the package will scan the different Font Awesome libraries and use the first library where it finds the icon.

The order in which the libraries are scanned is `regular`, `brands`, `solid`. But this can be modified in the [configuration](#configuration).

### Attributes

The `<x-fa>` component takes three possible attributes of which only the `name` is required.

| Attribute  | Type | Description |
| --- | --- | --- |
| `name` | string | The name of the icon |
| `library` | string | The font awesome library to find the icon in |
| `class` | string | Extra css classes to be appended to the svg output |

## Configuration

The package contains a few configuration options that can be modified by first publishing the config file using the command below. This will create a `fontawesome.php` file in your `config` folder.

    php artisan vendor:publish --provider="Jerodev\LaraFontAwesome\FontAwesomeServiceProvider"

| Key  | Type | Default value | Description |
| --- | --- | --- | --- |
| `component_name` | string  | `fa` | The name under which the component will be registered. Changing this value will also change the tag to be used in blade views. |
| `libraries` | string[]  | `['regular', 'brands', 'solid']` | The icon libraries that will be available. This is also the order in which the libraries will be searched for icons. |
| `svg_href` | bool| `true` | Use [svg href links](https://developer.mozilla.org/en-US/docs/Web/SVG/Attribute/href#use) for consecutive icons. |
