<?php
namespace rockunit\validate;

use rock\validate\Validate;

class IntTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerValid
     */
    public function testValid($input)
    {
        $validate = Validate::int();
        $this->assertTrue($validate->validate($input));
    }

    /**
     * @dataProvider providerInvalid
     */
    public function testInvalid($input)
    {
        $validate = Validate::int();
        $this->assertFalse($validate->validate($input));
    }

    public function providerValid()
    {
        return [
            [''],
            [16],
            ['165'],
            [123456],
            [PHP_INT_MAX],
        ];
    }

    public function providerInvalid()
    {
        return [
            [null],
            ['a'],
            [' '],
            ['Foo'],
            ['1.44'],
            [1e-5],
        ];
    }
}

