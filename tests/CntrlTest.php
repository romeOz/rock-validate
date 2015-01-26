<?php
namespace rockunit;

use rock\validate\rules\Cntrl;
use rock\validate\Validate;

class CntrlTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerValid
     */
    public function testValid($validCntrl, $additional='')
    {
        $validator = Validate::cntrl($additional);
        $this->assertTrue($validator->validate($validCntrl));
    }

    /**
     * @dataProvider providerInvalid
     */
    public function testInvalid($invalidCntrl, $additional='')
    {
        $validator = Validate::cntrl($additional);
        $this->assertFalse($validator->validate($invalidCntrl));
    }

    /**
     * @dataProvider providerForInvalidParams
     * @expectedException \rock\validate\ValidateException
     */
    public function testInvalidConstructorParamsShouldThrowComponentExceptionUponInstantiation($additional)
    {
        new Cntrl($additional);
    }

    /**
     * @dataProvider providerAdditionalChars
     */
    public function testAdditionalCharsShouldBeRespected($additional, $query)
    {
        $validator = Validate::cntrl($additional);
        $this->assertTrue($validator->validate($query));
    }

    public function providerAdditionalChars()
    {
        return [
            ['!@#$%^&*(){} ', '!@#$%^&*(){} '],
            ['[]?+=/\\-_|"\',<>. ', "[]?+=/\\-_|\"',<>. \t \n"],
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
            ["\n"],
            ["\r"],
            ["\t"],
            ["\n\r\t"],
            ["\n \n", ' '],
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
            [' '],
            ['Foo'],
            ['12.1'],
            ['-12'],
            [-12],
            ['alganet'],
        ];
    }
}