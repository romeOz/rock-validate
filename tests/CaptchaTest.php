<?php
namespace rockunit;

use rock\validate\Validate;

class CaptchaTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerValid
     */
    public function testValid($start, $input)
    {
        $v = Validate::captcha($start);
        $this->assertTrue($v->validate($input));
    }

    /**
     * @dataProvider providerInvalid
     */
    public function testInvalid($start, $input, $identical=false)
    {
        $v = Validate::captcha($start, $identical);
        $this->assertFalse($v->validate($input));
    }

    public function providerValid()
    {
        return [
            ['foo', 'foo'],
        ];
    }

    public function providerInvalid()
    {
        return [
            ['foo', 'bar'],
            [10, "10"],
        ];
    }
}

