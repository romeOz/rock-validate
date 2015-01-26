<?php
namespace rockunit;

use rock\validate\rules\In;
use rock\validate\Validate;

class InTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerValid
     *
     */
    public function testValid($input, $options = null, $strict = false)
    {
        $v = Validate::in($options, $strict);
        $this->assertTrue($v->validate($input));
    }

    /**
     * @dataProvider providerInvalid
     */
    public function testInvalid($input, $options, $strict = false)
    {
        $v =  Validate::in($options, $strict);
        $this->assertFalse($v->validate($input));
    }

    public function providerValid()
    {
        return [
            ['', 'barfoobaz'],
            ['foo', ['foo', 'bar']],
            ['foo', 'barfoobaz'],
            ['foo', 'foobarbaz'],
            ['foo', 'barbazfoo'],
            ['1', [1, 2, 3]],
            ['1', ['1', 2, 3], true],
        ];
    }

    public function providerInvalid()
    {
        return [
            ['bat', ['foo', 'bar']],
            ['foo', 'barfaabaz'],
            ['foo', 'faabarbaz'],
            ['foo', 'baabazfaa'],
            ['1', [1, 2, 3], true],
            ['foo', false],
        ];
    }
}