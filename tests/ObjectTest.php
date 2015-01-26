<?php
namespace rockunit;

use rock\validate\Validate;

class ObjectTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerValid
     */
    public function testValid($input)
    {
        $v = Validate::object();
        $this->assertTrue($v->validate($input));
    }

    /**
     * @dataProvider providerInvalid
     */
    public function testInvalid($input)
    {
        $v = Validate::object();
        $this->assertFalse($v->validate($input));
        $this->assertFalse($v->validate($input));
    }

    public function providerValid()
    {
        return [
            [new \stdClass],
            [new \ArrayObject],
        ];
    }

    public function providerInvalid()
    {
        return [
            // skip empty
            [''],
            [null],
            [[]],
            [121],
            ['Foo'],
            [false],
        ];
    }
}

