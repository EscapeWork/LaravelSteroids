<?php

namespace EscapeWork\LaravelSteroids;

trait Presentable
{
    /**
     * The presenter
     */
    protected $present;

    public function getPresentAttribute()
    {
        return $this->present();
    }

    protected function present()
    {
        if (! $this->present) {
            $this->present = new $this->presenter($this);
        }

        return $this->present;
    }
}
