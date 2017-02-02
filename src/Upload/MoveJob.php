<?php

namespace EscapeWork\LaravelSteroids\Upload;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MoveJob extends Job
{
    /**
     * Handle the command.
     *
     * @param  MediaSanitizeCommand  $command
     * @return void
     */
    public function handle($command, $next)
    {
        $command->files()->transform(function($item) use ($command) {
            $item['file']->storeAs(
                $command->dir,
                $item['name'],
                [
                    'visibility' => 'public',
                    'disk'       => $command->disk
                ]
            );

            return $item['name'];
        });

        return $next($command);
    }
}
