<?php

namespace EscapeWork\LaravelSteroids\Upload;

use Illuminate\Contracts\Bus\SelfHandling;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MoveJob extends Job implements SelfHandling
{

    /**
     * Handle the command.
     *
     * @param  MediaSanitizeCommand  $command
     * @return void
     */
    public function handle($command, $next)
    {
        $command->files()->transform(function ($item) use ($command) {
            $item['file']->move($command->dir, $item['name']);

            return $item['name'];
        });

        return $next($command);
    }
}