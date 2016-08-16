<?php

namespace EscapeWork\LaravelSteroids;

use Carbon\Carbon;
use InvalidArgumentException;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model as Eloquent;

abstract class Model extends Eloquent
{
    /**
     * Sluggable attribute
     * @var  string
     */
    protected $sluggableAttr = 'title';

    /**
     * Sluggable field
     * @var  string
     */
    protected $sluggableField = 'slug';

    /**
     * Variable to check if the model needs to make the slug when updating
     *
     * @var boolean
     */
    protected $makeSlugOnUpdate = true;

    public function setAttribute($key, $value)
    {
        parent::setAttribute($key, $value === '' ? null : $value);
    }

    /**
     * This functions must return the name identifier from the model
     * Example: $product->title, $client->name
     * It's used on the collection method, and you could use this in many other places (really)
     *
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    public function newCollection(array $models = array())
    {
        return new Collection($models);
    }

    public function _setDateAttribute($field, $value, $format = 'd/m/Y')
    {
        try {
            $this->attributes[$field] = Carbon::createFromFormat($format, $value);
        } catch (InvalidArgumentException $e) {
            $this->attributes[$field] = null;
        }
    }

    public function _setCurrencyAttribute($field, $value, $type = 'BRL')
    {
        if ($value == '') {
            $this->attributes[$field] = null;
            return;
        }
        if (is_float($value)) {
            $this->attributes[$field] = $value;
            return;
        }
        switch ($type) {
            case 'BRL':
                $value = str_replace('.', '', $value);
                $value = str_replace(',', '.', $value);
                break;
            default:
                $value = floatval($value);
        }
        $this->attributes[$field] = (float) $value;
    }

    public function scopeSearch($query, $field, $value)
    {
        $terms = explode(' ', $this->_removeRedexpValues($value));

        if (config('database.default') == 'sqlite') {
            return $query->where($field, 'like', '%'.$value.'%');
        }

        return $query->where($field, 'REGEXP', implode('.+', $terms));
    }

    public function scopeOrSearch($query, $field, $value)
    {
        $terms = explode(' ', $this->_removeRedexpValues($value));

        if (config('database.default') == 'sqlite') {
            return $query->orWhere($field, 'like', '%'.$value.'%');
        }

        return $query->orWhere($field, 'REGEXP', implode('.+', $terms));
    }

    public function _removeRedexpValues($value)
    {
        return trim(str_replace(['[', ']', '(', ')', '+'], ' ', $value));
    }

    public static function seed($data)
    {
        $model      = new static;
        $traits     = class_uses($model);
        $primaryKey = $model->primaryKey;

        if (in_array(SoftDeletes::class, $traits)) {
             if ($existing = static::withTrashed()->find($data[$primaryKey])) {
                $model = $existing;
             }
        } else {
            if ($existing = static::find($data[$primaryKey])) {
                $model = $existing;
             }
        }

        $model->fill($data);
        $model->save();
        return $model;
    }
}
