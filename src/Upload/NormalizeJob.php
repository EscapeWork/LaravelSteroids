<?php

namespace EscapeWork\LaravelSteroids\Upload;

use EscapeWork\LaravelSteroids\Upload\SanitizeFilenameService;
use EscapeWork\LaravelSteroids\Upload\UploadCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class NormalizeJob extends Job
{
    /**
     * @var EscapeWork\LaravelSteroids\Upload\UploadCollection
     */
    private $collection;

    public function __construct(UploadCollection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * Handle the command.
     *
     * @param  MediaSanitizeCommand  $command
     * @return void
     */
    public function handle($command, $next)
    {
        $files = $this->parseFilesIntoArray($command->files());

        $this->normalizeFiles($files, $command);
        $command->files($this->collection);

        return $next($command);
    }

    private function parseFilesIntoArray($files)
    {
        return $files instanceof UploadedFile ? [$files] : $files;
    }

    private function normalizeFiles(array $files, $command)
    {
        $sanitize = app(SanitizeFilenameService::class);

        foreach ($files as $file) {
            $filename = $sanitize->execute($file->getClientOriginalName(), $command->dir);

            $this->collection->push([
                'name' => $filename,
                'file' => $file,
            ]);
        }
    }
}
