<?php namespace EscapeWork\LaravelSteroids\Collections;

use Illuminate\Database\Eloquent\Collection;

class Collection extends Collection
{

    /**
     * Combobox options
     */
    protected $comboxBoxOptions = [
        'empty_option'       => true,
        'empty_option_label' => 'Selecione',
    ];

    public function combobox($options = [])
    {
        $options = array_merge($this->comboxBoxOptions, $options);
        $data    = [];

        if ($options['empty_option']) {
            $data[null] = $options['empty_option_label'];
        }

        foreach ($this->items as $item) {
            $data[$item->{$item->getKeyName()}] = $item->getTitle();
        }

        return $data;
    }
}
