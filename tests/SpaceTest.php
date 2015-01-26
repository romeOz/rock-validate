<?php
namespace rockunit;

use rock\validate\rules\Space;
use rock\validate\Validate;

class SpaceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerValid
     */
    public function testValid($validSpace, $additional='')
    {
        $validator = Validate::space($additional);
        $this->assertTrue($validator->validate($validSpace));
    }

    /**
     * @dataProvider providerInvalid
     */
    public function testInvalid($invalidSpace, $additional='')
    {
        $validator = Validate::space($additional);
        $this->assertFalse($validator->validate($invalidSpace));
    }

    /**
     * @dataProvider providerForInvalidParams
     * @expectedException \rock\validate\ValidateException
     */
    public function testInvalidConstructorParamsShouldThrowComponentExceptionUponInstantiation($additional)
    {
        new Space($additional);
    }

    /**
     * @dataProvider providerAdditionalChars
     */
    public function testAdditionalCharsShouldBeRespected($additional, $query)
    {
        $validator = Validate::space($additional);
        $this->assertTrue($validator->validate($query));
    }

    public function providerAdditionalChars()
    {
        return [
            ['!@#$%^&*(){}', '!@#$%^&*(){} '],
            ['[]?+=/\\-_|"\',<>.', "[]?+=/\\-_|\"',<>. \t \n "],
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
            [" "],
            ["    "],
            ["\t"],
            ["	"],
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
            ['_'],
        ];
    }
}