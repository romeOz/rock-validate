<?php
namespace rockunit\validate;

use rock\validate\Validate;

class NumericTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerValid
     */
    public function testValid($input)
    {
        $v = Validate::numeric();
        $this->assertTrue($v->validate($input));
    }

    /**
     * @dataProvider providerInvalid
     */
    public function testInvalid($input)
    {
        $v = Validate::numeric();
        $this->assertFalse($v->validate($input));
    }

    public function providerValid()
    {
        return [
            [''],
            [165],
            [165.0],
            [-165],
            ['165'],
            ['165.0'],
            ['+165.0'],
        ];
    }

    public function providerInvalid()
    {
        return [
            [null],
            ['a'],
            [' '],
            ['Foo'],
        ];
    }
}

