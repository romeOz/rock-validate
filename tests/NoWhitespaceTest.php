<?php
namespace rockunit;


use rock\validate\Validate;

class NoWhitespaceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerValid
     */
    public function testValid($input)
    {
        $v = Validate::noWhitespace();
        $this->assertTrue($v->validate($input));
    }

    /**
     * @dataProvider providerInvalid
     */
    public function testInvalid($input)
    {
        $v = Validate::noWhitespace();
        $this->assertFalse($v->validate($input));
    }

    public function testStringWithLineBreaksShouldFail()
    {
        $v = Validate::noWhitespace();
        $this->assertFalse($v->validate("f\noo"));
    }

    public function providerValid()
    {
        return [
            [''],
            [0],
            ['bar'],
            ['Foo'],
        ];
    }

    public function providerInvalid()
    {
        return [
            [' '],
            ['f oo'],
            ['      '],
            ["Foo\nBar"],
            ["Foo\tBar"],
        ];
    }
}