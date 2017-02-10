<?php

namespace EscapeWork\LaravelSteroids;

use Illuminate\Support\Str;

trait Sortable
{
    /**
     * @var array
     */
    protected $sortable = [
        'field' => 'order',
    ];

    public static function bootSortableTrait()
    {
        static::creating(function($model) {
            $model->{$model->sortable['field']} = $model->getNextOrder();
        });

        static::addGlobalScope(new SortableScope('order'));
    }

    public function getNextOrder()
    {
        return ((int) static::max($this->sortable['field'])) + 1;
    }
}
