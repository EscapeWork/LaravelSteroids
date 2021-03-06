<?php

namespace EscapeWork\LaravelSteroids\Upload;

use EscapeWork\LaravelSteroids\Upload\UploadCollection;

class UploadJob extends Job
{

    public $dir, $disk;
    private $files;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($files, $dir, $disk = null)
    {
        $this->files = $files;
        $this->dir   = $dir;
        $this->disk  = $disk;
    }


    public function files(UploadCollection $files = null)
    {
        if (is_null($files)) {
            return $this->files;
        }

        $this->files = $files;
    }

    /**
     * Handle the command.
     *
     * @return void
     */
    public function handle()
    {
        return $this->files;
    }
}
