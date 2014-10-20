<?php
namespace rockunit\validate;

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
        return array(
            [''],
            array('111111111111domain.local'),
            array('111111111111.domain.local'),
            array('example.com'),
            array('xn--bcher-kva.ch'),
            array('example-hyphen.com'),
            array('ёлка.рф'),
            array('пример.онлайн'),
        );
    }

    public function providerInvalid()
    {
        return array(
            array(null),
            array('-example-invalid.com'),
            array('example.invalid.-com'),
            array('1.2.3.256'),
            array('1.2.3.4'),
        );
    }
}

