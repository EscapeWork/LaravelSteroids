<?php

namespace EscapeWork\LaravelSteroids\Upload;

use EscapeWork\LaravelSteroids\Upload\ValidateFilenameService;

class ValidateJob extends Job
{
    /**
     * Handle the command.
     *
     * @param  MediaValidateCommand  $command
     * @return void
     */
    public function handle($command, $next)
    {
        $command->files()->transform(function($item) use ($command) {
            $validateService = app(ValidateFilenameService::class);

            return [
                'name' => $validateService->execute($command->dir, $item['name'], $command->disk),
                'file' => $item['file'],
            ];
        });

        return $next($command);
    }
}
