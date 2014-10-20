<?php
namespace rockunit\validate;

use rock\validate\Validate;

class RequiredTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerValid
     */
    public function testValid($input)
    {
        $v = Validate::required();
        $this->assertTrue($v->validate($input));
    }

    /**
     * @dataProvider providerInvalid
     */
    public function testInvalid($input)
    {
        $v = Validate::required();
        $this->assertFalse($v->validate($input));
    }

    public function providerValid()
    {
        return [
            [1],
            [' oi'],
            [[5]],
            [array(0)],
            [new \stdClass]
        ];
    }

    public function providerInvalid()
    {
        return [
            [''],
            ['    '],
            ["\n"],
            [false],
            [null],
            [[]]
        ];
    }
}

