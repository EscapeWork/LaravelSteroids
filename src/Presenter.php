<?php

namespace EscapeWork\LaravelSteroids;

abstract class Presenter
{

    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function __get($field)
    {
        if (method_exists($this, $field)) {
            return $this->{$field}();
        }

        return $this->model->{$field};
    }

    public function __call($method, $args)
    {
        if (method_exists($this, $method)) {
            return $this->{$method}($args);
        }

        return $this->model->{$method};
    }

    public function __append()
    {
        $data = [];

        foreach (get_class_methods($this) as $method) {
            if (substr($method, 0, 2) === '__') {
                continue;
            }

            $data[$method] = $this->{$method}();
        }

        return $data;
    }
}
