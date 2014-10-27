<?php
namespace rockunit\validate;



use rock\validate\Validate;


class WhenTest extends \PHPUnit_Framework_TestCase
{
    public function testValid()
    {
        // scalar
        $v = Validate::when(Validate::equals('5'), Validate::string());
        $this->assertTrue($v->validate('5'));
        $this->assertEmpty($v->getErrors());

        // not else
        $v = Validate::when(Validate::equals('5', true), Validate::string());
        $this->assertTrue($v->validate(5));
        $this->assertEmpty($v->getErrors());

        // array
        $input = [
            'email' => 'tom@site.com',
            'firstname' => 'Tom',
        ];
        $v = Validate::when(
            Validate::attributes(['email' => Validate::required()->email()]),
            Validate::attributes(['firstname' => Validate::required()->string()])
        );
        $this->assertTrue($v->validate($input));
        $this->assertEmpty($v->getErrors());

        // else
        $input = [
            'email' => '',
            'firstname' => 'Tom',
        ];
        $v = Validate::when(
            Validate::attributes(['email' => Validate::required()->email()]),
            Validate::attributes(['firstname' => Validate::required()->string()]),
            Validate::attributes(['firstname' => Validate::required()->string()])
        );
        $this->assertTrue($v->validate($input));
        $this->assertEmpty($v->getErrors());
    }


    public function testInvalid()
    {
        // scalar
        $v = Validate::when(Validate::equals('5'), Validate::string());
        $this->assertFalse($v->validate(5));
        $this->assertSame(
            [
                'string' => 'value must be string',
            ],
            $v->getErrors()
        );

        // else
        $input = [
            'email' => '',
            'firstname' => 'Tom',
        ];
        $v = Validate::when(
            Validate::attributes(['email' => Validate::required()->email()]),
            Validate::attributes(['firstname' => Validate::required()->string()]),
            Validate::attributes(['firstname' => Validate::required()->int()])
        );
        $this->assertFalse($v->validate($input));
        $this->assertSame(
            [
                'firstname' =>
                    [
                        'int' => 'value must be an integer number',
                    ],
            ],
            $v->getErrors()
        );
    }
}