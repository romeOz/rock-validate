<?php
namespace rockunit\validate;



use rock\validate\rules\Alnum;
use rock\validate\Validate;

class AlnumTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerValid
     */
    public function testValid($validAlnum, $additional)
    {
        $validator = Validate::alnum($additional);
        $this->assertTrue($validator->validate($validAlnum));
    }

    /**
     * @dataProvider providerInvalid
     */
    public function testInvalid($invalidAlnum, $additional)
    {
        $validator = Validate::alnum($additional);
        $this->assertFalse($validator->validate($invalidAlnum));
    }

    /**
     * @dataProvider providerInvalid
     */
    public function testInvalidRu($invalidAlnum, $additional)
    {
        $validator = Validate::locale(Validate::RU)->alnum($additional);
        $this->assertFalse($validator->validate($invalidAlnum));
    }

    /**
     * @dataProvider providerInvalidParams
     * @expectedException \rock\validate\Exception
     */
    public function testThrowException($additional)
    {
        new Alnum($additional);
    }

    /**
     * @dataProvider providerAdditionalChars
     */
    public function testAdditionalCharsShouldBeRespected($additional, $query)
    {
        $validator = Validate::alnum($additional);
        $this->assertTrue($validator->validate($query));
    }

    public function providerAdditionalChars()
    {
        return [
            ['!@#$%^&*(){}', '!@#$%^&*(){} abc 123'],
            ['[]?+=/\\-_|"\',<>.', "[]?+=/\\-_|\"',<>. \t \n abc 123"],
        ];
    }

    public function providerInvalidParams()
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
            ['', ''],
            ['alganet', ''],
            ['alganet', 'alganet'],
            ['0alg-anet0', '0-9'],
            ['1', ''],
            ["\t", ''],
            ["\n", ''],
            ['a', ''],
            ['foobar', ''],
            ['rubinho_', '_'],
            ['google.com', '.'],
            ['alganet alganet', ''],
            ["\nabc", ''],
            ["\tdef", ''],
            ["\nabc \t", ''],
            [0, ''],
        ];
    }

    public function providerInvalid()
    {
        return [
            ['@#$', ''],
            ['_', ''],
            ['dgç', ''],
            [1e21, ''], //evaluates to "1.0E+21"
            [null, ''],
            [new \stdClass, ''],
            [[], ''],
        ];
    }
}