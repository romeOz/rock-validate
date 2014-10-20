<?php
namespace rockunit\validate;

use rock\validate\rules\Graph;
use rock\validate\Validate;

class GraphTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerValid
     */
    public function testValid($validGraph, $additional='')
    {
        $validator = Validate::graph($additional);
        $this->assertTrue($validator->validate($validGraph));
    }

    /**
     * @dataProvider providerInvalid
     */
    public function testInvalid($invalidGraph, $additional='')
    {
        $validator = Validate::graph($additional);
        $this->assertFalse($validator->validate($invalidGraph));
    }

    /**
     * @dataProvider providerForInvalidParams
     * @expectedException \rock\validate\Exception
     */
    public function testInvalidConstructorParamsShouldThrowComponentExceptionUponInstantiation($additional)
    {
        new Graph($additional);
    }

    /**
     * @dataProvider providerAdditionalChars
     */
    public function testAdditionalCharsShouldBeRespected($additional, $query)
    {
        $validator = Validate::graph($additional);
        $this->assertTrue($validator->validate($query));
    }

    public function providerAdditionalChars()
    {
        return [
            [' ', '!@#$%^&*(){} abc 123'],
            [" \t\n", "[]?+=/\\-_|\"',<>. \t \n abc 123"],
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
            [''],
            ['LKA#@%.54'],
            ['foobar'],
            ['16-50'],
            ['123'],
            ['#$%&*_'],
        ];
    }

    public function providerInvalid()
    {
        return [
            [null],
            ["foo\nbar"],
            ["foo\tbar"],
            ['foo bar'],
            [' '],
        ];
    }
}