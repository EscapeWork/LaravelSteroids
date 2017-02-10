<?php

trait OrdenableTrait
{
    /**
     * Sortable fields
     */
    protected $ordenables = [];

    /**
     * Default order by field
     * @var [type]
     */
    protected $ordenableDefault = [
        'field'     => 'created_at',
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
