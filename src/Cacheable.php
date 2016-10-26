<?php

namespace EscapeWork\LaravelSteroids;

use Illuminate\Support\Facades\Cache;

trait Cacheable
{
    public static function bootCacheable()
    {
        static::saved(function($model) {
            $model->clearCaches($model);
        });

        static::deleted(function($model) {
            $model->clearCaches($model);
        });
    }

    public function clearCaches($model)
    {
        foreach ($this->cacheables as $cacheable) {
            preg_match_all("/{.+}/", $cacheable, $matches);

            foreach ($matches[0] as $match) {
                $field      = str_replace(['{', '}'], [''], $match);
                $value      = $model->{$field};
                $cacheables = [];

                foreach ((array) $value as $matched) {
                    $cacheables[] = str_replace($match, $matched, $cacheable);
                }

                $cacheable = $cacheables;
            }

            foreach ((array) $cacheable as $cached) {
                Cache::forget($cached);
            }
        }
    }
}
