<?php
namespace rockunit\validate;

use rock\validate\rules\Negative;
use rock\validate\Validate;

class NegativeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerValid
     */
    public function testValid($input)
    {
        $v = Validate::negative();
        $this->assertTrue($v->validate($input));
    }

    /**
     * @dataProvider providerInvalid
     */
    public function testInvalid($input)
    {
        $v = Validate::negative();
        $this->assertFalse($v->validate($input));
    }

    public function providerValid()
    {
        return [
            [''],
            ['-1.44'],
            [-1e-5],
            [-10],
        ];
    }

    public function providerInvalid()
    {
        return [
            [0],
            [-0],
            [null],
            ['a'],
            [' '],
            ['Foo'],
            [16],
            ['165'],
            [123456],
            [1e10],
        ];
    }
}

