<?php
namespace rockunit;

use rock\validate\Validate;

class FloatTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerValid
     */
    public function testValid($input)
    {
        $validate = Validate::float();
        $this->assertTrue($validate->validate($input));
    }

    /**
     * @dataProvider providerInvalid
     */
    public function testInvalid($input)
    {
        $validate = Validate::float();
        $this->assertFalse($validate->validate($input));
    }

    public function providerValid()
    {
        return [
            [165],
            [1],
            [0],
            [0.0],
            ['1'],
            ['19347e12'],
            [165.0],
            ['165.7'],
            [1e12],
        ];
    }

    public function providerInvalid()
    {
        return [
            [''],
            [null],
            [[]],
            ['a'],
            [' '],
            ['Foo'],
        ];
    }
}