<?php

namespace EscapeWork\LaravelSteroids\Upload;

use Illuminate\Contracts\Bus\SelfHandling;

class ValidateJob extends Job implements SelfHandling
{

    /**
     * Handle the command.
     *
     * @param  MediaValidateCommand  $command
     * @return void
     */
    public function handle($command, $next)
    {
        $command->files()->transform(function ($item) use ($command) {
            $validateService = app('EscapeWork\LaravelSteroids\Upload\ValidateFilenameService');

            return [
                'name' => $validateService->execute($command->dir, $item['name']),
                'file' => $item['file'],
            ];
        });

        return $next($command);
    }
}
