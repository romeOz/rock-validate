<?php
namespace rockunit;



use rock\validate\rules\Alpha;
use rock\validate\Validate;

class AlphaTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerValid
     */
    public function testValid($validAlpha, $additional)
    {
        $validator = Validate::alpha($additional);
        $this->assertTrue($validator->validate($validAlpha));
    }

    /**
     * @dataProvider providerInvalid
     */
    public function testInvalid($invalidAlpha, $additional)
    {
        $validator = Validate::alpha($additional);
        $this->assertFalse($validator->validate($invalidAlpha));
    }

    /**
     * @dataProvider providerForInvalidParams
     * @expectedException \rock\validate\ValidateException
     */
    public function testThrowException($additional)
    {
        new Alpha($additional);
    }

    /**
     * @dataProvider providerAdditionalChars
     */
    public function testAdditionalCharsShouldBeRespected($additional, $query)
    {
        $validator = Validate::alpha($additional);
        $this->assertTrue($validator->validate($query));
    }

    public function providerAdditionalChars()
    {
        return [
            ['!@#$%^&*(){}', '!@#$%^&*(){} abc'],
            ['[]?+=/\\-_|"\',<>.', "[]?+=/\\-_|\"',<>. \t \n abc"],
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
            ['alganet', ''],
            ['alganet', 'alganet'],
            ['0alg-anet0', '0-9'],
            ['a', ''],
            ["\t", ''],
            ["\n", ''],
            ['foobar', ''],
            ['rubinho_', '_'],
            ['google.com', '.'],
            ['alganet alganet', ''],
            ["\nabc", ''],
            ["\tdef", ''],
            ["\nabc \t", ''],
        ];
    }

    public function providerInvalid()
    {
        return [
            ['', ''],
            [null, ''],
            [[], ''],
            ['@#$', ''],
            ['_', ''],
            ['dgç', ''],
            ['122al', ''],
            ['122', ''],
            [11123, ''],
            [1e21, ''],
            [0, ''],
            [new \stdClass, ''],
        ];
    }
}