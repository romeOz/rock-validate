<?php
namespace rockunit;

use rock\validate\Validate;

class OddTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerValid
     */
    public function testValid($input)
    {
        $v = Validate::odd();
        $this->assertTrue($v->validate($input));
    }

    /**
     * @dataProvider providerInvalid
     */
    public function testInvalid($input)
    {
        $v = Validate::odd();
        $this->assertFalse($v->validate($input));
    }

    public function providerValid()
    {
        return [
            [''],
            [-5],
            [-1],
            [1],
            [13],
        ];
    }

    public function providerInvalid()
    {
        return [
            [-2],
            [-0],
            [0],
            [32],
        ];
    }
}

