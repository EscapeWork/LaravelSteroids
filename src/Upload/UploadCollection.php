<?php

namespace EscapeWork\LaravelSteroids\Upload;

use Illuminate\Support\Collection;

class UploadCollection extends Collection
{

    public function __toString()
    {
        $first = $this->first();

        if (isset($first['name'])) {
            return $first['name'];
        }

        return $first;
    }
}
