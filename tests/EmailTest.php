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
     * @dataProvider roviderInvalid
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
            ['a@a.a']
        ];
    }

    public function roviderInvalid()
    {
        return [
            ['test@test'],
            ['test'],
            ['@test.com'],
            ['mail@test@test.com'],
            ['test.test@'],
            ['test.@test.com'],
            ['test@.test.com'],
            ['test@test..com'],
            ['test@test.com.'],
            ['.test@test.com']
        ];
    }
}

