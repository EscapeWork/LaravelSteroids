<?php

use EscapeWork\LaravelSteroids\Collection;

class CollectionTest extends PHPUnit_Framework_TestCase
{

    /** @test */
    public function test_transpose()
    {
        $collection = new Collection([[
            'name'       => 'Jane',
            'occupation' => 'Doctor',
            'email'      => 'jane@example.com',
        ],
        [
            'name'       => 'Bob',
            'occupation' => 'Plumber',
            'email'      => 'bob@example.com',
        ],
        [
            'name'       => 'Mary',
            'occupation' => 'Dentist',
            'email'      => 'mary@example.com',
        ]]);

        $data = $collection->transpose();

        $this->assertEquals($data[0][1], 'Bob');
        $this->assertEquals($data[1][2], 'Dentist');
    }
}
