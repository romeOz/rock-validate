<?php
namespace rockunit;

use rock\validate\Validate;

class DomainTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerValid
     */
    public function testValid($input)
    {
        $v = Validate::domain();
        $this->assertTrue($v->validate($input));
    }

    /**
     * @dataProvider providerInvalid
     */
    public function testInvalid($input)
    {
        $v = Validate::domain();
        $this->assertFalse($v->validate($input));
    }

    public function providerValid()
    {
        return [
            // skip empty
            [''],
            [null],
            [[]],

            ['111111111111domain.local'],
            ['111111111111.domain.local'],
            ['example.com'],
            ['xn--bcher-kva.ch'],
            ['example-hyphen.com'],
            ['ёлка.рф'],
            ['пример.онлайн'],
        ];
    }

    public function providerInvalid()
    {
        return [
            ['-example-invalid.com'],
            ['example.invalid.-com'],
            ['1.2.3.256'],
            ['1.2.3.4'],
        ];
    }
}

