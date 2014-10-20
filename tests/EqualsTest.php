<?php
namespace rockunit\validate;

use rock\validate\Validate;

class EqualsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerValid
     */
    public function testValid($start, $input)
    {
        $v = Validate::equals($start);
        $this->assertTrue($v->validate($input));
    }

    /**
     * @dataProvider providerInvalid
     */
    public function testInvalid($start, $input, $identical=false)
    {
        $v = Validate::equals($start, $identical);
        $this->assertFalse($v->validate($input));
    }

    public function providerValid()
    {
        return [
            ['foo', 'foo'],
            [10, "10"],
        ];
    }

    public function providerInvalid()
    {
        return [
            ['foo', 'bar'],
            [10, "10", true],
        ];
    }
}

