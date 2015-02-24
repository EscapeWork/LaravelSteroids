<?php namespace EscapeWork\LaravelSteroids;

use Illuminate\Database\Eloquent\Model as Eloquent;

abstract class Model extends Eloquent 
{

    public function setAttribute($key, $value)
    {
        parent::setAttribute($key, $value === '' ? null : $value);
    }

    public function getTitle()
    {
    	return $this->title;
    }
}