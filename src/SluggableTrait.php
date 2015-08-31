<?php

namespace EscapeWork\LaravelSteroids;

use Illuminate\Support\Str;

trait SluggableTrait
{

    public function update(array $attributes = array())
    {
        if ($this->isSluggable()) {
            $this->_makeSlug();
        }

        return parent::update($attributes);
    }

    public function save(array $options = array())
    {
        if ($this->isSluggable()) {
            $this->_makeSlug();
        }

        return parent::save($options);
    }

    protected function isSluggable()
    {
        if ($this->exists && ! $this->makeSlugOnUpdate) {
            return false;
        }

        return true;
    }

    protected function _makeSlug()
    {
        $field = $this->sluggableField;
        $attr  = $this->sluggableAttr;

        $this->{$field} = Str::slug($this->{$attr});
        $count      = 0;

        while ($this->slugExists()) {
            $count++;
            $this->{$field} = Str::slug($this->$attr) . '-' . $count;
        }
    }

    protected function slugExists()
    {
        $key   = $this->primaryKey;
        $field = $this->sluggableField;

        $query = $this->where($field, '=', $this->$field);

        if ($this->exists) {
            $query->where($key, '<>', $this->$key);
        }

        return $query->first();
    }

    public function setSluggable($sluggable)
    {
        $this->sluggable = $sluggable;
    }
}
