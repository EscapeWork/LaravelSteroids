<?php

namespace EscapeWork\LaravelSteroids\Upload;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;

class MimeTypeArrayValidator
{

    public function validate($attribute, $files, $parameters)
    {
        $parameters = count($parameters) === 0 ? ['jpg', 'jpeg', 'pjpeg', 'png'] : $parameters;

        if (! is_array($files)) {
            return false;
        }

        if (count($files) === 0 || is_null($files[0])) {
            return true;
        }

        foreach ($files as $file) {
            if (! $this->validateMimes($attribute, $file, $parameters)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check that the given value is a valid file instance.
     *
     * @param  mixed  $value
     * @return bool
     */
    protected function isAValidFileInstance($value)
    {
        if ($value instanceof UploadedFile && ! $value->isValid()) return false;

        return $value instanceof File;
    }

    /**
     * Validate the MIME type of a file upload attribute is in a set of MIME types.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  array   $parameters
     * @return bool
     */
    protected function validateMimes($attribute, $value, $parameters)
    {
        if (! $this->isAValidFileInstance($value)) {
            return false;
        }

        return $value->getPath() != '' && in_array($value->guessExtension(), $parameters);
    }


}
