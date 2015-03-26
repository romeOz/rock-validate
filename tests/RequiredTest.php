<?php
namespace rockunit;

use rock\validate\Validate;

class RequiredTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerValid
     */
    public function testValid($input, $strict = true)
    {
        $v = Validate::required($strict);
        $this->assertTrue($v->validate($input));
    }

    /**
     * @dataProvider providerInvalid
     */
    public function testInvalid($input, $strict = true)
    {
        $v = Validate::required($strict);
        $this->assertFalse($v->validate($input));
    }

    public function providerValid()
    {
        return [
            [1],
            [' oi'],
            [[5]],
            [[0]],
            [new \stdClass],

            [0, false],
            [1, false],
            [[], false],
            ['0', false],
            ['1', false],
            [false, false],
        ];
    }

    public function providerInvalid()
    {
        return [
            [''],
            [0],
            ['    '],
            ["\n"],
            [false],
            [null],
            [[]],

            ['', false],
            [null, false]
        ];
    }
}

