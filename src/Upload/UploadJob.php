<?php

namespace EscapeWork\LaravelSteroids\Upload;

use Illuminate\Contracts\Bus\SelfHandling;
use EscapeWork\LaravelSteroids\Upload\UploadCollection;

class UploadJob extends Job implements SelfHandling
{

    public $dir;
    private $files;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($files, $dir)
    {
        $this->files = $files;
        $this->dir   = $dir;
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


