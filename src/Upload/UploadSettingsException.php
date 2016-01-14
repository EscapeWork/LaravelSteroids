<?php

namespace EscapeWork\LaravelSteroids\Upload;

use Exception;

class UploadSettingsException extends Exception
{

    public function __construct($message = null)
    {
        if (is_null($message)) {
            $message = 'Config file not specified';
        }

        $this->message = $message;
    }
}
