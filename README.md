TinyLara\TinyView
=====
[![Latest Stable Version](https://poser.pugx.org/tinylara/tinyview/v/stable.svg)](https://packagist.org/packages/tinylara/tinyview) [![Total Downloads](https://poser.pugx.org/tinylara/tinyview/downloads.svg)](https://packagist.org/packages/tinylara/tinyview) [![License](https://poser.pugx.org/tinylara/tinyview/license.svg)](https://packagist.org/packages/tinylara/tinyview)

TinyView is a tiny view-loader used by [Tinylara](http://tinylara.com), fast and sexy!

### Install

If you have Composer, just include TinyView as a project dependency in your `composer.json`. If you don't just install it by downloading the .ZIP file and extracting it to your project directory.

```
require: {
    "tinylara/tinyview": "*"
}
```

### Examples

Load it:

```php
// VIEW_BASE_PATH
define('VIEW_BASE_PATH', __DIR__.'/app/views/');

// View Loader
class_alias('\TinyLara\TinyView\TinyView','View');
```

Use it:

```php
$view = View::make('home')->with('article',Article::first())
                          ->withTitle('TinyLara :-D')
                          ->withFooBar('foo_bar');
View::process($view);
```

### License

The TinyView is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
