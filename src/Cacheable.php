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
            preg_match_all('/{.+}/', $cacheable, $bindings);

            if (count($bindings) > 0) {
                $bind   = $bindings[0][0];
                $field  = str_replace(['{', '}'], ['', ''], $bind);
                $values = (array) $this->{$field};

                foreach ($values as $value) {
                    Cache::forget(str_replace($bind, $value, $cacheable));
                }
            } else {
                Cache::forget($cacheable);
            }
        }
    }
}
