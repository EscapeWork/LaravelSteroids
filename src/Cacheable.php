<?php

namespace EscapeWork\LaravelSteroids;

use Illuminate\Support\Facades\Cache;

trait Cacheable
{
    public static function bootCacheable()
    {
        static::saved(function($model) {
            $model->clearCaches();
        });

        static::deleted(function($model) {
            $model->clearCaches();
        });
    }

    public function clearCaches()
    {
        foreach ($this->cacheables as $cacheable) {
            Cache::forget($this->table.'.'.$cacheable);
        }
    }
}
