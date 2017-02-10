<?php

trait OrdenableTrait
{
    /**
     * Sortable fields
     */
    protected $ordenables = [
        'products.price',
        'products.hits',
    ];

    /**
     * Default order by field
     * @var [type]
     */
    protected $ordenableDefault = [
        'field'     => 'products.hits',
        'direction' => 'desc',
    ];

    public function scopeOrder($query, $field, $direction = 'desc')
    {
        if (in_array($field, $this->ordenables)) {
            $query->orderBy($field, $direction);
        } else {
            if (isset($this->ordenableDefault['field'])) {
                $query->orderBy($this->ordenableDefault['field'], isset($this->ordenableDefault['direction']) ? $this->ordenableDefault['direction'] : null);
            }
        }

        return $query;
    }
}
