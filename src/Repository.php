<?php namespace EscapeWork\LaravelSteroids;

abstract class Repository 
{

    protected $model;

    public function setModel($model)
    {
        $this->model = $model;
    }

    public function __call($method, $args)
    {
        return call_user_func_array(array($this->model, $method), $args);
    }

    public function __get($key)
    {
        return $this->model->getAttribute($key);
    }

    public function __set($key, $value)
    {
        $this->model->setAttribute($key, $value);
    }
}