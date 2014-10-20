<?php
namespace rockunit\validate;

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
        return array(
            array(''),
            array(16),
            array('165'),
            array(123456),
            array(1e10),
        );
    }

    public function providerInvalid()
    {
        return array(
            array(null),
            array('a'),
            array(' '),
            array('Foo'),
            array('-1.44'),
            array(-1e-5),
            array(0),
            array(-0),
            array(-10),
        );
    }
}