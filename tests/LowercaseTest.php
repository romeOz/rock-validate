<?php
namespace rockunit;


use rock\validate\Validate;

class LowercaseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerValid
     */
    public function testValid($input)
    {
        $v = Validate::lowercase();
        $this->assertTrue($v->validate($input));
    }

    /**
     * @dataProvider providerInvalid
     */
    public function testInvalid($input)
    {
        $v = Validate::lowercase();
        $this->assertFalse($v->validate($input));
    }

    public function providerValid()
    {
        return [
            [''],
            ['lowercase'],
            ['lowercase-with-dashes'],
            ['lowercase with spaces'],
            ['lowercase with numbers 123'],
            ['lowercase with specials characters like ã ç ê'],
            ['with specials characters like # $ % & * +'],
            ['τάχιστη αλώπηξ βαφής ψημένη γη, δρασκελίζει υπέρ νωθρού κυνός'],
        ];
    }

    public function providerInvalid()
    {
        return [
            ['UPPERCASE'],
            ['CamelCase'],
            ['First Character Uppercase'],
            ['With Numbers 1 2 3'],
        ];
    }
}