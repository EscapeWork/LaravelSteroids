<?php namespace EscapeWork\LaravelSteroids;

use Illuminate\Database\Eloquent\Model as Eloquent;

abstract class Model extends Eloquent 
{

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
}