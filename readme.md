## Laravel on Steroids

[![Build Status](https://travis-ci.org/EscapeWork/LaravelSteroids.png)](http://travis-ci.org/EscapeWork/LaravelSteroids) [![Latest Stable Version](https://poser.pugx.org/escapework/laravel-steroids/v/stable.png)](https://packagist.org/packages/escapework/laravel-steroids) [![Total Downloads](https://poser.pugx.org/escapework/laravel-steroids/downloads.png)](https://packagist.org/packages/escapework/laravel-steroids)

Just some goodies for making your Laravel Project even better.

### Installation

```sh
$ composer require "escapework/laravel-steroids:0.2.*"
```

### Usage

We offer a lot of base classes and helpers. Take a look.

#### Presenters

Just add a `PresentableTrait` in your model:

```php
use EscapeWork\LaravelSteroids\PresentableTrait;

class Product extends Model
{
    use PresentableTrait;

    protected $presenter = 'App\Presenters\ProductPresenter';
}
```

And create your presenter:

```php
use EscapeWork\LaravelSteroids\Presenter;

class ProductPresenter extends Presenter
{
    public function title()
    {
        // $this->model gives you access to your model inside the presenter
        return ucwords($this->model->title);
    }
}
```

Then, you can just call the presenter methods like this:

```php
$product = Product::find(1);
echo $product->present->title;
```

#### Cacheable

Cacheable is a model trait that clean up some cache keys when your model is changed/deleted. To use it, just add the `Cacheable` trait on your model:

```php
use EscapeWork\LaravelSteroids\Cacheable;

class Product extends Model
{
    use Cacheable;

    protected $cacheable = [
        'actives',
        'all',
        // here you need to put your cache keys that need to be cleared
        // rembmer: they will be fogot with the table name as prefix
        // example: products.actives, products.all
    ];
}
```
