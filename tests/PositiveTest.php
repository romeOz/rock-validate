<?php
namespace rockunit;

use rock\validate\rules\Positive;
use rock\validate\Validate;

class PositiveTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerValid
     */
    public function testValid($input)
    {
        $v = Validate::positive();
        $this->assertTrue($v->validate($input));
    }

    /**
     * @dataProvider providerInvalid
     */
    public function testInvalid($input)
    {
        $v = Validate::positive();
        $this->assertFalse($v->validate($input));
    }

    public function providerValid()
    {
        return [
            // skip empty
            [''],
            [null],
            [[]],
            
            [16],
            ['165'],
            [123456],
            [1e10],
        ];
    }

    public function providerInvalid()
    {
        return [
            ['a'],
            [' '],
            ['Foo'],
            ['-1.44'],
            [-1e-5],
            [0],
            [-0],
            [-10],
        ];
    }
}