<?php
namespace rockunit;

use rock\validate\Validate;

class NullValueTest extends \PHPUnit_Framework_TestCase
{
    public function testValid()
    {
        $v = Validate::nullValue();
        $this->assertTrue($v->validate(null));
    }

    /**
     * @dataProvider providerInvalid
     */
    public function testInvalid($input)
    {
        $v = Validate::nullValue();
        $this->assertFalse($v->validate($input));
    }

    public function providerInvalid()
    {
        return [
            [0],
            ['w poiur'],
            [' '],
            ['Foo'],
        ];
    }
}