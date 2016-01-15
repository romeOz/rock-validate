<?php
namespace rockunit;


use rock\validate\Validate;

class StartsWithTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerValid
     */
    public function testValid($start, $input)
    {
        $v = Validate::startsWith($start);
        $this->assertTrue($v->validate($input));
    }

    /**
     * @dataProvider providerInvalid
     */
    public function testInvalid($start, $input, $caseSensitive = false)
    {
        $v = Validate::startsWith($start, $caseSensitive);
        $this->assertFalse($v->validate($input));
    }

    public function providerValid()
    {
        return [
            ['foo', ''],
            ['foo', ['foo', 'bar']],
            ['foo', 'FOObarbaz'],
            ['foo', 'foobarbaz'],
            ['foo', 'foobazfoo'],
            ['1', [1, 2, 3]],
            ['1', ['1', 2, 3], true],
        ];
    }

    public function providerInvalid()
    {
        return [
            ['bat', ['foo', 'bar']],
            ['foo', 'barfaabaz'],
            ['foo', 'FOObarbaz', true],
            ['foo', 'faabarbaz'],
            ['foo', 'baabazfaa'],
            ['foo', 'baafoofaa'],
            ['1', [1, '1', 3], true],
        ];
    }
}