<?php
namespace rockunit;


use rock\validate\Validate;

class EmailTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerValid
     */
    public function testValid($email)
    {
        $validator = Validate::email();
        $this->assertTrue($validator->validate($email));
    }

    /**
     * @dataProvider providerInvalid
     */
    public function testInvalid($email)
    {
        $validator = Validate::email();
        $this->assertFalse($validator->validate($email));
    }

    public function providerValid()
    {
        return [
            ['test@test.com'],
            ['mail+mail@gmail.com'],
            ['test@тест.рф'],
            ['mail.email@e.test.com'],
            ['a@a.a'],
            ['петя@тест.рф'],
            ['test@золотой-ларец.рф'],
            ['test@золотой--ларец.рф'],
            ['test@test.xn--p1ai'],
            ['contact@xn----8sbpfklcuba0as3d.xn--p1ai'],
            ['test@exämple.com'],
            ['test@ä-.xe'],
            ['test@wähwähwäh.ümläüts.de'],
            ['user@[255.255.255.255]'],
            ['user@[IPv6:2001:db8:1ff::a0b:dbd0]'],
            ['user@[IPv6:2001:0db8:85a3:08d3:1319:8a2e:0370:7344]'],
            ['user@[IPv6:1111:2222:3333:4444:5555:6666:255.255.255.255]']
        ];
    }

    public function providerInvalid()
    {
        return [
            ['test@t@test'],
            [' test@t@test'],
            ['test@test'],
            ['test'],
            ['test@'],
            ['@test.com'],
            ['@'],
            ['mail@test@test.com'],
            ['test@test.com-'],
            ['foo@-foo.com'],
            ['foo@foo-.com'],
            ['test..child@example.com'],
            ['test@sub.-example.com'],
            ['test@_smtp_.example.com'],
            ['test@sub.-example.com'],
            ['(comment)test@test.com'],
            ['this\ still\"not\allowed@example.com'],
            ['test.test@'],
            ['test.@test.com'],
            ['test@.test.com'],
            ['test@test..com'],
            ['test@test.com.'],
            ['.test@test.com'],
            ['test@a[255.255.255.255]'],
            ['test@[255.255.255]'],
            ['test@[255.255.255.255.255]'],
            ['test@[255.255.255.256]'],
            ['test@[2001::7344]'],
            ['test@[IPv6:1111:2222:3333:4444:5555:6666:7777:255.255.255.255]'],
            ['test@[1.2.3.4'],
        ];
    }
}

