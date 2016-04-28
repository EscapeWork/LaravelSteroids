## Laravel on Steroids

[![Build Status](https://travis-ci.org/EscapeWork/LaravelSteroids.png)](http://travis-ci.org/EscapeWork/LaravelSteroids) [![Latest Stable Version](https://poser.pugx.org/escapework/laravel-steroids/v/stable.png)](https://packagist.org/packages/escapework/laravel-steroids) [![Total Downloads](https://poser.pugx.org/escapework/laravel-steroids/downloads.png)](https://packagist.org/packages/escapework/laravel-steroids)

Just some goodies for making your Laravel Project even better.

### Installation

```sh
$ composer require "escapework/laravel-steroids:0.2.*"
```

### Usage

We offer a lot of base classes. Take a look.

#### Models

Instead extends the regular Laravel Eloquent Model, you will need to extend ours:

```php
use EscapeWork\LaravelSteroids\Model;

class Product extends Model
{

}
```
