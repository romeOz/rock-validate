<?php
namespace rockunit;

use rock\validate\Validate;

class JsonTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerValid
     */
    public function testValid($input)
    {
        $v = Validate::json();
        $this->assertTrue($v->validate($input));
    }

    public function testInvalid()
    {
        $v = Validate::json();
        $this->assertFalse($v->validate("{foo:bar}"));
    }

    public function providerValid()
    {
        return [
            ['2'],
            ['"abc"'],
            ['[1,2,3]'],
            ['["foo", "bar", "number", 1]'],
            ['{"foo": "bar", "number":1}'],
        ];
    }
}