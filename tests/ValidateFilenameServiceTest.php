<?php

use EscapeWork\LaravelSteroids\Upload\ValidateFilenameService;
use Mockery as m;

class ValidateFilenameServiceTest extends PHPUnit_Framework_TestCase
{

    /** @test */
    public function test_if_validates_filename_correctly()
    {
        $filesystem = m::mock(Illuminate\Filesystem\Filesystem::class);
        $validator  = new ValidateFilenameService($filesystem);
    }
}
