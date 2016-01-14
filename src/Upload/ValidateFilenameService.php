<?php

namespace EscapeWork\LaravelSteroids\Upload;

use Illuminate\Filesystem\Filesystem;

class ValidateFilenameService
{

    /**
     * @var Illuminate\Filesystem\Filesystem
     */
    protected $filesystem;

    /**
     * @var array
     */
    protected static $names = [];

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function execute($basepath, $filename)
    {
        $path      = $basepath . '/' . $filename;
        $extension = $this->filesystem->extension($filename);
        $filename  = str_replace('.' . $extension, null, $filename);
        $count     = 0;

        while ($this->filesystem->exists($path) || in_array($path, static::$names)) {
            $count++;

            $path = $basepath . '/' . $filename . '-' . $count . '.' . $extension;
        }

        static::$names[] = $path;

        if ($count === 0) {
            return $filename . '.' . $extension;
        }

        return $filename . '-' . $count . '.' . $extension;
    }
}
