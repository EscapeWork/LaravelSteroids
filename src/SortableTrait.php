<?php

namespace EscapeWork\LaravelSteroids;

use Illuminate\Support\Str;

trait SortableTrait
{

    /**
     * @var array
     */
    protected $sortable = [
        'field' => 'order',
    ];

    public function bootSortableTrait()
    {
        static::creating(function() {
            $this->{$this->sortable['field']} = $this->getNextOrder();
        });
    }

    public function getNextOrder()
    {
        return ((int) static::max($this->sortable['field'])) + 1;
    }
}
