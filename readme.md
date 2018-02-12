# Laravel on Steroids

[![Build Status](https://travis-ci.org/EscapeWork/LaravelSteroids.png)](http://travis-ci.org/EscapeWork/LaravelSteroids) [![Latest Stable Version](https://poser.pugx.org/escapework/laravel-steroids/v/stable.png)](https://packagist.org/packages/escapework/laravel-steroids) [![Total Downloads](https://poser.pugx.org/escapework/laravel-steroids/downloads.png)](https://packagist.org/packages/escapework/laravel-steroids) [![MIT Licence](https://img.shields.io/packagist/l/EscapeWork/laramedias.svg?style=flat)](https://github.com/EscapeWork/LaravelSteroids)

Just some goodies for making your Laravel Project even better.

## Version Compatibility

 Laravel       | Laravel on Steroids
:--------------|:-------------------
 5.5.x - 5.6.x | 0.7.x@dev
 5.4.x         | 0.6.x
 5.3.x         | 0.5.x
 5.2.x         | 0.4.x
 5.1.x         | 0.3.x

## Installation

```sh
$ composer require escapework/laravel-steroids:"0.7.*"
```

## Usage

We offer a lot of base classes and helpers. Take a look.

First of all, your models now need to extend your base model.

```php
use EscapeWork\LaravelSteroids\Model;

class Product extends Model
{
}
```

### Presenters

Just add a `Presentable` in your model:

```php
use EscapeWork\LaravelSteroids\Presentable;

class Product extends Model
{
    use Presentable;

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

### Sluggable

Want to make slugs with your model? Just add the `Sluggable` to your model.

```php
use EscapeWork\LaravelSteroids\Sluggable;

class Product extends Model
{
    use Sluggable;
}
```

By default, when your model is created/updated, `Sluggable` will take your `$title` attribute, create a unique slug and put the value in the `$slug` attribute.
If you want to change the field that is used to create the slug, just put a `$sluggableAttr` property on your model. And if you want to change the slug field, add the `$sluggableField` property.

```php
class User extends Model
{
    use Sluggable;
    protected $sluggableAttr  = 'name';
    protected $sluggableField = 'username';
}
```

If you don't want the slug to be updated when your model is updated, set the `$makeSlugOnUpdate` property to `false`;

### Cacheable

Cacheable is a model trait that clean up some cache keys when your model is changed/deleted. To use it, just add the `Cacheable` trait on your model:

```php
use EscapeWork\LaravelSteroids\Cacheable;

class Product extends Model
{
    use Cacheable;

    protected $cacheable = [
        // here you need to put your cache keys that need to be cleared
        'products.actives',
        'products.all',

        // you can also use some attribute to be replaced
        // in this case, the {category_id} will be replaced with $product->category_id,
        'products.category.{category_id}'
    ];
}
```

### Sortable

Do you want to sort your models automatically? Easy.

```php
use EscapeWork\LaravelSteroids\Sortable;

class Banner extends Model
{
    use Sortable;
}
```

Then:

```php
Banner::create(['title' => 'First Banner'])->order;  // 1
Banner::create(['title' => 'Second Banner'])->order; // 2
```

If you `order` field is not called `order`, you just need to specify:

```php
protected $sortable = [
    'field' => 'order',
];
```

### Ordenable

Want to easily change the orderBy in your query? Easy.

```php
use EscapeWork\LaravelSteroids\Ordenable;

class Product extends Model
{
    use Ordenable;

    protected $ordenables = [
        'price',
        'hits'
    ];

    protected $ordenableDefault = [
        'field'     => 'created_at',
        'direction' => 'desc',
    ];
}
```

Then, when querying:

```php
$products = Product::where(...)->order('price', 'desc')->get();
```

If you try to order for a field that is not in the `$ordenables` array, your results will be sorted with the `$ordenableDefault` values.

## License

See the [License](https://github.com/EscapeWork/LaravelSteroids/blob/master/LICENSE) file.
