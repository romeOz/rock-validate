<?php

namespace rockunit\validation;

use rock\validate\Exception;
use rock\validate\locale\en\Date;
use rock\validate\locale\en\Numeric;
use rock\validate\Validate;

class ValidateTest extends \PHPUnit_Framework_TestCase
{
    public function testRequired()
    {
        $validate = Validate::required();
        $this->assertTrue($validate->validate('foo'));
        $this->assertEmpty($validate->getErrors());
        // negative
        $this->assertFalse($validate->validate(''));
        $this->assertSame(['required' => 'value must not be empty'], $validate->getErrors());
        $this->assertFalse($validate->validate(0));
        $this->assertSame(['required' => 'value must not be empty'], $validate->getErrors());
    }

    /**
     * @dataProvider providerStringValid
     * @param string $value
     */
    public function testStringValid($value)
    {
        $validate = Validate::string();
        $this->assertTrue($validate->validate($value));
        $this->assertEmpty($validate->getErrors());
    }

    public function providerStringValid()
    {
        return [
            ['foo'],
            [''],
        ];
    }

    /**
     * @dataProvider providerStringInvalid
     * @param mixed $value
     */
    public function testStringInvalid($value)
    {
        $validate = Validate::string();
        $this->assertFalse($validate->validate($value));
        $this->assertSame(['string' => 'value must be string'], $validate->getErrors());
    }

    public function providerStringInvalid()
    {
        return [
            [new \stdClass()],
            [0],
            [
                function () {
                }
            ],
            [5.5]
        ];
    }


    /**
     * @dataProvider providerNumericValid
     * @param int|float $value
     */
    public function testNumericValid($value)
    {
        $validate = Validate::numeric();
        $this->assertTrue($validate->validate($value));
        $this->assertEmpty($validate->getErrors());
    }

    public function providerNumericValid()
    {
        return [
            [''],
            [0],
            [5],
            [5.5]
        ];
    }

    /**
     * @dataProvider providerNumericInvalid
     * @param mixed $value
     */
    public function testNumericInvalid($value)
    {
        $validate = Validate::numeric();
        $this->assertFalse($validate->validate($value));
        $this->assertSame(['numeric' => 'value must be numeric'], $validate->getErrors());
    }

    public function providerNumericInvalid()
    {
        return [
            [new \stdClass()],
            ['foo'],
            [
                function () {
                }
            ]
        ];
    }


    /**
     * @dataProvider providerArrValid
     * @param mixed $value
     */
    public function testArrValid($value)
    {
        $validate = Validate::arr();
        $this->assertTrue($validate->validate($value));
    }

    public function providerArrValid()
    {
        return [
            [''],
            [[]],
            [['foo']],
        ];
    }

    /**
     * @dataProvider providerArrInvalid
     * @param mixed $value
     */
    public function testArrInvalid($value)
    {
        $validate = Validate::arr();
        $this->assertFalse($validate->validate($value));
        $this->assertSame(['arr' => 'value must be an array'], $validate->getErrors());
    }

    public function providerArrInvalid()
    {
        return [
            [new \stdClass()],
            ['foo'],
            [
                function () {
                }
            ],
            [7]
        ];
    }

    /**
     * @dataProvider providerMinValid
     * @param mixed $value
     * @param int      $min
     */
    public function testMinValid($value, $min, $inclusive)
    {
        $validate = Validate::min($min, $inclusive);
        $this->assertTrue($validate->validate($value));
    }

    public function providerMinValid()
    {
        return [
            [7, 6, false],
            [6, 6, true],
        ];
    }

    /**
     * @dataProvider providerMinInvalid
     * @param mixed $value
     * @param int      $min
     */
    public function testMinInvalid($value, $min, $inclusive)
    {
        $validate = Validate::min($min, $inclusive);
        $this->assertFalse($validate->validate($value));
        $this->assertSame(['min' => 'value must be greater than 6'], $validate->getErrors());
    }

    public function providerMinInvalid()
    {
        return [
            [5, 6, false],
            [6, 6, false],
            ['6', 6, false],
            ['a', 6, false],
        ];
    }

    /**
     * @dataProvider providerMaxValid
     * @param mixed $value
     * @param int      $max
     */
    public function testMaxValid($value, $max, $inclusive)
    {
        $validate = Validate::max($max, $inclusive);
        $this->assertTrue($validate->validate($value));
    }

    public function providerMaxValid()
    {
        return [
            [5, 6, false],
            [6, 6, true],
            ['2005-11-30 00:30:00', '2005-11-30 01:00:00', false],
            [new \DateTime('2005-11-30 00:30:00'), new \DateTime('2005-11-30 01:00:00'), false],
            ['2005-11-30 01:00:00', '2005-11-30 01:00:00', true],
        ];
    }

    /**
     * @dataProvider providerMaxInvalid
     * @param mixed $value
     * @param int      $max
     */
    public function testMaxInvalid($value, $max, $inclusive)
    {
        $validate = Validate::max($max, $inclusive);
        $this->assertFalse($validate->validate($value));
        if ($max instanceof \DateTime) {
            $max = $max->format('Y-m-d H:i:s');
        }
        $this->assertSame(['max' => "value must be lower than {$max}"], $validate->getErrors());
    }

    public function providerMaxInvalid()
    {
        return [
            [7, 6, false],
            [6, 6, false],
            ['6', 6, false],
            ['2005-11-30 10:30:00', '2005-11-30 01:00:00', false],
            ['2005-11-30 01:00:00', '2005-11-30 01:00:00', false],
            [new \DateTime('2005-11-30 10:30:00'), new \DateTime('2005-11-30 01:00:00'), false],
        ];
    }

    public function testDate()
    {
        $validate = Validate::date()->templates(['date' => Date::FORMAT]);
        $this->assertTrue($validate->validate('2005-11-30 01:02:03'));
        $this->assertEmpty($validate->getErrors());

        // negative
        $validate = Validate::date();
        $this->assertFalse($validate->validate('foo'));
        $this->assertSame(
            ['date' => 'value must be date'],
            $validate->getErrors()
        );
        $validate = Validate::date('Y-d')->templates(['date' => Date::FORMAT]);
        $this->assertFalse($validate->validate('2005-11-30 01:02:03'));
        $this->assertSame(
            ['date' => 'value must be a valid date. Sample format: 2005-30'],
            $validate->getErrors()
        );
        $validate->templates([])->validate('2005-11-30 01:02:03');
        $this->assertSame(
            ['date' => 'value must be date'],
            $validate->getErrors()
        );

        // custom placeholder
        $validate = Validate::date('Y-d')->placeholders(['format' => 'bar'])->templates(['date' => Date::FORMAT]);
        $this->assertFalse($validate->validate('2005-11-30 01:02:03'));
        $this->assertSame(
            ['date' => 'value must be a valid date. Sample format: bar'],
            $validate->getErrors()
        );
    }

    public function testBetween()
    {
        $validate = Validate::between(6, 8);
        $this->assertFalse($validate->validate(6));
        $this->assertSame(
            ['between' => 'value must be between 6 and 8']
            ,$validate->getErrors()
        );
        $this->assertTrue($validate->validate(7));

        //placeholder
        $validate = Validate::between(6, 7)->placeholders(['name' => 'num']);
        $this->assertFalse($validate->validate(5));
        $this->assertSame(
            ['between' => 'num must be between 6 and 7']
            ,$validate->getErrors()
        );

        $validate = Validate::between(6);
        $this->assertFalse($validate->validate(5));
        $this->assertSame(
            ['between' => 'value must be greater than 6'],
            $validate->getErrors()
        );

        $validate = Validate::between(null, 7);
        $this->assertTrue($validate->validate(5));
        $this->assertEmpty($validate->getErrors());

        // notOf
        $validate = Validate::notOf(Validate::between(null, 7)->placeholders(['name' => 'num']));
        $this->assertFalse($validate->validate(5));
        $this->assertSame(
            ['between' => 'num must not be lower than 7'],
            $validate->getErrors()
        );

        $validate = Validate::between(6, 7, true);
        $this->assertTrue($validate->validate(6));

        // Date
        $validate = Validate::between(new \DateTime('2005-12-30 01:00:00'), new \DateTime('2005-12-30 02:00:00'));
        $this->assertFalse($validate->validate('2005-12-30 00:30:00'));
        $this->assertSame(
            [
                'between' => 'value must be between 2005-12-30 01:00:00 and 2005-12-30 02:00:00',
            ],
            $validate->getErrors()
        );

        $this->assertFalse($validate->validate(new \DateTime('2005-12-30 00:30:00')));
        $this->assertSame(
            [
                'between' => 'value must be between 2005-12-30 01:00:00 and 2005-12-30 02:00:00',
            ],
            $validate->getErrors()
        );

        $validate = Validate::between('2005-12-30 01:00:00', '2005-12-30 02:00:00');
        $this->assertFalse($validate->validate('2005-12-30 01:00:00'));
        $this->assertSame(
            [
                'between' => 'value must be between 2005-12-30 01:00:00 and 2005-12-30 02:00:00',
            ],
            $validate->getErrors()
        );

        $validate = Validate::between('2005-12-30 01:00:00', '2005-12-30 02:00:00', true);
        $this->assertTrue($validate->validate('2005-12-30 01:00:00'));

        $validate = Validate::between(new \DateTime('2005-12-30 01:00:00'));
        $this->assertFalse($validate->validate('2005-12-30 01:00:00'));
        $this->assertSame(
            [
                'between' => 'value must be greater than 2005-12-30 01:00:00',
            ],
            $validate->getErrors()
        );
        $validate = Validate::between(new \DateTime('2005-12-30 01:00:00'), null, true);
        $this->assertTrue($validate->validate('2005-12-30 01:00:00'));

        $validate = Validate::between(null, '2005-12-30 02:00:00');
        $this->assertTrue($validate->validate('2005-12-30 01:00:00'));
    }

    public function testTemplate()
    {
        $validate = Validate::required()
            ->numeric()
            ->templates(['numeric' => Numeric::STANDARD])
            ->placeholders(['name' => 'email']);
        $this->assertFalse($validate->validate('foo'));
        $this->assertSame(
            ['numeric' => 'email must be numeric'],
            $validate->getErrors());
    }

    public function testCustomMessage()
    {
        $validate = Validate::required()
            ->numeric()
            ->templates(['numeric' => Numeric::STANDARD])
            ->placeholders(['name' => 'email'])
            ->messages(['numeric' => 'custom message']);
        $this->assertFalse($validate->validate('foo'));
        $this->assertSame(
            ['numeric' => 'custom message'],
            $validate->getErrors());
    }

    public function testNotOf()
    {
        $validate = Validate::notOf(
            Validate::required()->numeric()->placeholders(
                ['name' => 'email'])
        );
        $this->assertTrue($validate->validate(''));
        $validate = Validate::notOf(
            Validate::required()->string()->placeholders(['name' => 'email']));
        $this->assertTrue($validate->validate(''));
        $validate = Validate::notOf(
            Validate::required()->string()->placeholders(['name' => 'email']));
        $this->assertFalse($validate->validate('foo'));
        $this->assertSame(
            [
                'required' => 'email must be empty',
                'string' => 'email must not be string',
            ],
            $validate->getErrors()
        );
        $validate = Validate::required()->notOf(
            Validate::numeric()->placeholders(['name' => 'email']));
        $this->assertFalse($validate->validate(5));
        $this->assertSame(['numeric' => 'email must not be numeric'], $validate->getErrors());
    }

    public function testAllOf()
    {
        $input = [
            'email' => 'tom@site.com',
            'name' => 'Tom'
        ];
        $validate = Validate::allOf(
            [
                'email' => Validate::required()
                    ->string()
                    ->placeholders(['name' => 'email']),
                'name' => Validate::required()->string()
            ]
        );
        $this->assertTrue($validate->validate($input));
        $this->assertEmpty($validate->getErrors());
        // negative
        $input = [
            'email' => null,
            'name' => 'Tom'
        ];
        $validate = Validate::notOf(
            Validate::allOf(
                [
                    'username' => Validate::required(),
                    'email' => Validate::required()
                        ->numeric()
                        ->placeholders(['name' => 'email']),
                    'name' => Validate::required()->string()
                ]
            ));
        $this->assertFalse($validate->validate($input));
        $expected = [
            'name' =>
                [
                    'required' => 'value must be empty',
                    'string' => 'value must not be string',
                ],
        ];
        $this->assertSame($expected, $validate->getErrors());
        $validate = Validate::allOf(
            [
                'username' => Validate::required(),
                'email' => Validate::notOf(Validate::required())
                    ->numeric()
                    ->placeholders(['name' => 'email']),
                'name' => Validate::required()->notOf(
                    Validate::string()->placeholders(['name' => 'email']))
            ]
        );
        $this->assertFalse($validate->validate($input));
        $expected = [
            'username' =>
                [
                    'required' => 'value must not be empty',
                ],
            'email' =>
                [
                    'numeric' => 'email must be numeric',
                ],
            'name' =>
                [
                    'string' => 'email must not be string',
                ],
        ];
        $this->assertSame($expected, $validate->getErrors());
    }


    public function testAllOfAsObject()
    {
        $input = (object)[
            'email' => '',
            'name' => 'Tom'
        ];
        $validate = Validate::notOf(
            Validate::allOf(
                [
                    'username' => Validate::required(),
                    'email' => Validate::required()
                        ->numeric()
                        ->placeholders(['name' => 'email']),
                    'name' => Validate::required()->string()
                ]
            ));
        $this->assertFalse($validate->validate($input));
        $expected = [
            'name' =>
                [
                    'required' => 'value must be empty',
                    'string' => 'value must not be string',
                ],
        ];
        $this->assertSame($expected, $validate->getErrors());
    }

    /**
     * @expectedException Exception
     */
    public function testAllOfException()
    {
        $array = [
            'email' => 'tom@site.com',
            'name' => 'Tom'
        ];
        $validate = Validate::allOf(
            [
                'email' => Validate::required()
                    ->string()
                    ->placeholders(['name' => 'email']),
                'name' => Validate::required()->string()->validate('foo')
            ]
        );
        $validate->validate($array);
    }

    /**
     * @dataProvider providerInputOneOf
     */
    public function testOneOf($input)
    {
        // valid
        $validate = Validate::oneOf(
            [
                'email' => Validate::required()
                    ->string()
                    ->placeholders(['name' => 'email']),
                'name' => Validate::required()->string()
            ]
        );
        $this->assertTrue($validate->validate($input));
        $this->assertEmpty($validate->getErrors());

        // invalid
        $validate = Validate::oneOf(
            [
                'username' => Validate::required(),
                'email' => Validate::notOf(Validate::required())
                    ->numeric()
                    ->placeholders(['name' => 'email']),
                'name' => Validate::required()->notOf(
                    Validate::string()->placeholders(['name' => 'email']))
            ]
        );
        $this->assertFalse($validate->validate($input));
        $expected = [
            'username' =>
                [
                    'required' => 'value must not be empty',
                ],
        ];
        $this->assertSame($expected, $validate->getErrors());
    }

    public function providerInputOneOf()
    {
        return [
            [
                [
                    'email' => 'tom@site.com',
                    'name' => 'Tom'
                ]
            ],
            [
                (object)[
                    'email' => 'tom@site.com',
                    'name' => 'Tom'
                ]
            ],
        ];
    }

    /**
     * @expectedException Exception
     */
    public function testOneOfException()
    {
        $array = [
            'email' => 'tom@site.com',
            'name' => 'Tom'
        ];
        $validate = Validate::oneOf(
            [
                'email' => Validate::required()
                    ->string()
                    ->placeholders(['name' => 'email']),
                'name' => Validate::required()->string()->validate('foo')
            ]
        );
        $validate->validate($array);
    }

    public function testGetFirstError()
    {
        $validate = Validate::required()
            ->numeric()
            ->placeholders(['name' => 'email']);
        $this->assertFalse($validate->validate(''));
        $this->assertSame('email must not be empty', $validate->getFirstError());
        // not error
        $validate = Validate::string();
        $this->assertTrue($validate->validate(''));
        $this->assertEmpty($validate->getFirstError());
        // all off
        $array = [
            'email' => null,
            'name' => 'Tom'
        ];
        $validate = Validate::allOf(
            [
                'username' => Validate::required(),
                'email' => Validate::notOf(Validate::required())
                    ->numeric()
                    ->placeholders(['name' => 'email']),
                'name' => Validate::required()->notOf(
                    Validate::string()->placeholders(['name' => 'email']))
            ]
        );
        $this->assertFalse($validate->validate($array));
        $this->assertSame('value must not be empty', $validate->getFirstError());
        $this->assertSame('email must be numeric', $validate->getFirstError('email'));
    }

    public function testGetLastError()
    {
        $validate = Validate::required()
            ->numeric()
            ->placeholders(['name' => 'email']);
        $this->assertFalse($validate->validate(''));
        $validate = Validate::required()
            ->numeric()
            ->placeholders(['name' => 'email']);
        $this->assertFalse($validate->validate('foo'));
        $this->assertSame('email must be numeric', $validate->getLastError());
        // not error
        $validate = Validate::string();
        $this->assertTrue($validate->validate(''));
        $this->assertEmpty($validate->getLastError());
        // all off
        $array = [
            'email' => null,
            'name' => 'Tom'
        ];
        $validate = Validate::allOf(
            [
                'username' => Validate::required(),
                'email' => Validate::notOf(Validate::required())
                    ->numeric()
                    ->placeholders(['name' => 'email']),
                'name' => Validate::required()->notOf(
                    Validate::string()->placeholders(['name' => 'name']))
            ]
        );
        $this->assertFalse($validate->validate($array));
        $this->assertSame('name must not be string', $validate->getLastError());
        $this->assertSame('email must be numeric', $validate->getLastError('email'));
    }

    /**
     * @expectedException Exception
     */
    public function testUnknownRule()
    {
        $validate = Validate::unknown();
        $validate->validate('foo');
    }

    /**
     * @expectedException Exception
     */
    public function testClassNotExists()
    {
        $config = [
            'rules' => [
                'bar' => [
                    'class' => 'bar',
                    'locales' => [
                        Validate::EN => \rock\validate\locale\en\Writable::className(),
                        Validate::RU => \rock\validate\locale\ru\Writable::className(),
                    ]
                ],
            ]
        ];

        $validate = (new Validate($config))->bar();
        $validate->validate('foo');
    }

    /**
     * @expectedException Exception
     */
    public function testClassI18NNotExists()
    {
        $config = [
            'rules' => [
                'required' => [
                    'class' => 'bar',
                    'locales' => [
                        Validate::EN => 'foo',
                        Validate::RU => 'bar',
                    ]
                ],
            ]
        ];

        $validate = (new Validate($config))->required();
        $validate->validate('foo');
    }

    public function testI18N()
    {
        $validate = Validate::locale(Validate::RU)->required();
        $this->assertFalse($validate->validate(''));
        $this->assertSame(['required' => 'значение не должно быть пустым'], $validate->getErrors());
    }
}
 