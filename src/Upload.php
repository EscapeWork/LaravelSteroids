<?php

namespace EscapeWork\LaravelSteroids;

use EscapeWork\LaravelSteroids\Upload\UploadSettingsException;
use EscapeWork\LaravelSteroids\Upload\UploadJob;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Foundation\Bus\DispatchesJobs;

class Upload
{

    /**
     * @trait Illuminate\Foundation\Bus\DispatchesJobs
     */
    use DispatchesJobs;

    /**
     * @var Illuminate\Contracts\Bus\Dispatcher
     */
    private $dispatcher;

    private $dir;

    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
        $this->dir        = './storage/app/upload';
    }

    public function to($dir)
    {
        $this->dir = $dir;

        return $this;
    }

    public function execute($files)
    {
        if (empty($this->dir)) {
            throw new UploadSettingsException;
        }

        $this->dispatcher->pipeThrough([
            'EscapeWork\LaravelSteroids\Upload\NormalizeJob',
            'EscapeWork\LaravelSteroids\Upload\ValidateJob',
            'EscapeWork\LaravelSteroids\Upload\MoveJob',
        ]);

        $dispatched = $this->dispatch(new UploadJob($files, $this->dir));
        $this->dispatcher->pipeThrough([]);

        return $dispatched;
    }
}
