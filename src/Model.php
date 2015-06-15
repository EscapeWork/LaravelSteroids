<?php namespace EscapeWork\LaravelSteroids;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Carbon\Carbon;
use InvalidArgumentException;

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

    public static function seed($data)
    {
        $model      = new static;
        $traits     = class_uses($model);
        $primaryKey = $model->primaryKey;

        if (in_array('Illuminate\Database\Eloquent\SoftDeletingTrait', $traits)) {
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
    }
}
