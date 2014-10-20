<?php
namespace rockunit\validate;

use rock\validate\Validate;

class Confirm extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerValid
     */
    public function testValid($start, $input)
    {
        $v = Validate::confirm($start);
        $this->assertTrue($v->validate($input));
    }

    /**
     * @dataProvider providerInvalid
     */
    public function testInvalid($start, $input, $identical=false)
    {
        $v = Validate::confirm($start, $identical);
        $this->assertFalse($v->validate($input));
    }

    public function providerValid()
    {
        return [
            ['foo', 'foo'],
        ];
    }

    public function providerInvalid()
    {
        return [
            ['foo', 'bar'],
            [10, "10"],
        ];
    }
}