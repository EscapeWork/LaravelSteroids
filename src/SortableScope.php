<?php

namespace EscapeWork\LaravelSteroids;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\Scope;

class SortableScope implements Scope
{

    private $column;
    private $direction;

    public function __construct($column, $direction = 'asc')
    {
        $this->column    = $column;
        $this->direction = $direction;
    }

    public function apply(Builder $builder, EloquentModel $model)
    {
        $builder->orderBy($this->column, $this->direction);
    }

    public function remove(Builder $builder, EloquentModel $model)
    {
        $query = $builder->getQuery();

        $query->orders = collect($query->orders)->reject(function ($order) {
            return $order['column'] == $this->column && $order['direction'] == $this->direction;
        })->values()->all();

        if (count($query->orders) == 0) {
            $query->orders = null;
        }
    }
}
