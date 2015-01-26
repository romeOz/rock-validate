<?php
namespace rockunit;

use rock\validate\rules\Digit;
use rock\validate\Validate;

class DigitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerValid
     */
    public function testValid($validDigits, $additional='')
    {
        $validator = Validate::digit($additional);
        $this->assertTrue($validator->validate($validDigits));
    }

    /**
     * @dataProvider providerInvalid
     */
    public function testInvalid($invalidDigits, $additional='')
    {
        $validator = Validate::digit($additional);
        $this->assertFalse($validator->validate($invalidDigits));
    }

    /**
     * @dataProvider providerForInvalidParams
     * @expectedException \rock\validate\ValidateException
     */
    public function testThrowComponentException($additional)
    {
        new Digit($additional);
    }

    /**
     * @dataProvider providerAdditionalChars
     */
    public function testAdditionalCharsShouldBeRespected($additional, $query)
    {
        $validator = Validate::digit($additional);
        $this->assertTrue($validator->validate($query));
    }

    public function providerAdditionalChars()
    {
        return [
            ['!@#$%^&*(){}', '!@#$%^&*(){} 123'],
            ['[]?+=/\\-_|"\',<>.', "[]?+=/\\-_|\"',<>. \t \n 123"],
        ];
    }

    public function providerForInvalidParams()
    {
        return [
            [new \stdClass],
            [[]],
            [0x2]
        ];
    }

    public function providerValid()
    {
        return [
            ["\n\t"],
            [' '],
            [165],
            [1650],
            ['01650'],
            ['165'],
            ['1650'],
            ['16 50'],
            ["\n5\t"],
            ['16-50', '-'],
        ];
    }

    public function providerInvalid()
    {
        return [
            [''],
            [null],
            [[]],
            ['16-50'],
            ['a'],
            ['Foo'],
            ['12.1'],
            ['-12'],
            [-12],
        ];
    }
}