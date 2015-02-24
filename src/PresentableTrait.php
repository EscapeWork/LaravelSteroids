<?php namespace EscapeWork\LaravelSteroids;

use ReflectionClass;

trait PresentableTrait
{

    /**
     * The presenter
     */
    protected $present;

    /**
     * The presenter class
     */
    protected $presenter;

    public function getPresentAttribute()
    {
        return $this->present();
    }

    protected function present()
    {
        if (! $this->presenter) {
			$reflection      = new ReflectionClass($this);
			$this->presenter = new $presenter($this);
        }

        return $this->presenter;
    }
}
