<?php

namespace EscapeWork\LaravelSteroids;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ScopeInterface;

class SortableScope implements ScopeInterface
{

    private $column;
    private $direction;

    public function __construct($column, $direction = 'asc')
    {
        $this->column    = $column;
        $this->direction = $direction;
    }

    public function apply(Builder $builder, Model $model)
    {
        $builder->orderBy($this->column, $this->direction);
    }

    public function remove(Builder $builder, Model $model)
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
