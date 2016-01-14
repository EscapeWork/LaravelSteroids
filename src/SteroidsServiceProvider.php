<?php

namespace EscapeWork\LaravelSteroids;

use Illuminate\Support\ServiceProvider;

class SteroidsServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->app->validator->extend(
            'mime_type_array',
            'EscapeWork\LaravelSteroids\Upload\MimeTypeArrayValidator@validate'
        );
    }

    public function register()
    {

    }
}
