<?php
namespace rockunit;

use rock\validate\rules\Uppercase;
use rock\validate\Validate;

class UppercaseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerValid
     */
    public function testValid($input)
    {
        $v = Validate::uppercase();
        $this->assertTrue($v->validate($input));
    }

    /**
     * @dataProvider providerInvalid
     */
    public function testInvalid($input)
    {
        $v = Validate::uppercase();
        $this->assertFalse($v->validate($input));
    }

    public function providerValid()
    {
        return [
            [''],
            ['UPPERCASE'],
            ['UPPERCASE-WITH-DASHES'],
            ['UPPERCASE WITH SPACES'],
            ['UPPERCASE WITH NUMBERS 123'],
            ['UPPERCASE WITH SPECIALS CHARACTERS LIKE Ã Ç Ê'],
            ['WITH SPECIALS CHARACTERS LIKE # $ % & * +'],
            ['ΤΆΧΙΣΤΗ ΑΛΏΠΗΞ ΒΑΦΉΣ ΨΗΜΈΝΗ ΓΗ, ΔΡΑΣΚΕΛΊΖΕΙ ΥΠΈΡ ΝΩΘΡΟΎ ΚΥΝΌΣ'],
        ];
    }

    public function providerInvalid()
    {
        return [
            ['lowercase'],
            ['CamelCase'],
            ['First Character Uppercase'],
            ['With Numbers 1 2 3'],
        ];
    }
}

