<?php

namespace EscapeWork\LaravelSteroids\Upload;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

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

    public function execute($basepath, $filename, $disk = null)
    {
        $path      = $basepath . '/' . $filename;
        $extension = mb_strtolower($this->filesystem->extension($filename));
        $filename  = str_replace('.' . $extension, null, $filename);
        $count     = 0;

        while (Storage::disk($disk)->exists($path) || in_array($path, static::$names)) {
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
