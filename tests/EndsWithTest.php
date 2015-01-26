<?php
namespace rockunit;

use rock\validate\rules\EndsWith;
use rock\validate\Validate;

class EndsWithTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerValid
     */
    public function testValid($start, $input)
    {
        $v = Validate::endsWith($start);
        $this->assertTrue($v->validate($input));
    }

    /**
     * @dataProvider providerInvalid
     */
    public function testInvalid($start, $input, $caseSensitive = false)
    {
        $v = Validate::endsWith($start, $caseSensitive);
        $this->assertFalse($v->validate($input));
    }

    public function providerValid()
    {
        return [
            ['foo', ''],
            ['foo', ['bar', 'foo']],
            ['foo', 'barbazFOO'],
            ['foo', 'barbazfoo'],
            ['foo', 'foobazfoo'],
            ['1', [2, 3, 1]],
            ['1', [2, 3, '1'], true],
        ];
    }

    public function providerInvalid()
    {
        return [
            ['bat', ['bar', 'foo']],
            ['foo', 'barfaabaz'],
            ['foo', 'barbazFOO', true],
            ['foo', 'faabarbaz'],
            ['foo', 'baabazfaa'],
            ['foo', 'baafoofaa'],
            ['1', [1, '1', 3], true],
        ];
    }
}

