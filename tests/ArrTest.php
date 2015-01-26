<?php
namespace rockunit;



use rock\validate\Validate;

class TestAccess extends \ArrayObject implements \ArrayAccess, \Countable, \Traversable
{
}

class ArrTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerValid
     */
    public function testValid($input)
    {
        $v = Validate::arr();
        $this->assertTrue($v->validate($input));
    }

    /**
     * @dataProvider providerInvalid
     */
    public function testInvalid($input)
    {
        $v = Validate::arr();
        $this->assertFalse($v->validate($input));
    }

    public function providerValid()
    {
        return [
            [[]],
            [[1, 2, 3]],
            [new TestAccess],
        ];
    }

    public function providerInvalid()
    {
        return [
            [''],
            [null],
            [121],
            [new \stdClass],
            [false],
            ['aaa'],
        ];
    }
}