<?php
namespace rockunit;

use rock\validate\rules\StringRule;
use rock\validate\Validate;

class StringRuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerValid
     */
    public function testValid($input)
    {
        $v = Validate::string();
        $this->assertTrue($v->validate($input));
    }

    /**
     * @dataProvider providerInvalid
     */
    public function testNotString($input)
    {
        $v = Validate::string();
        $this->assertFalse($v->validate($input));
    }

    public function providerValid()
    {
        return [
            [''],
            ['165.7'],
        ];
    }

    public function providerInvalid()
    {
        return [
            [null],
            [[]],
            [new \stdClass],
            [150]
        ];
    }
}