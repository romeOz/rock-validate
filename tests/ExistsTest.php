<?php

namespace rockunit;


use rock\validate\Validate;
use rockunit\mocks\ExistsMock;

class ExistsTest extends \PHPUnit_Framework_TestCase
{
    /** @var  Validate */
    protected $v;
    protected function setUp()
    {
        $config = [
            'rules' => [
                'exists' => [
                    'class' => ExistsMock::className(),
                    'locales' => [
                        'en' => \rock\validate\locale\en\Exists::className(),
                        'ru' => \rock\validate\locale\ru\Exists::className(),
                    ]
                ],
            ]
        ];
        $this->v = new Validate($config);
    }

    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();
        unset($GLOBALS['file_exists']);
    }

    public function testValid()
    {
        $GLOBALS['file_exists'] = true;
        $v = $this->v->exists();
        $input = __DIR__ . '/../src/valid/readable/file.txt';
        $this->assertTrue($v->validate($input));
    }

    public function testInvalid()
    {
        $GLOBALS['file_exists'] = false;
        $v = $this->v->exists();
        $input = __DIR__ . '/../src/invalid/readable/file.txt';
        $this->assertFalse($v->validate($input));
    }

    public function testShouldValidateObjects()
    {
        $GLOBALS['file_exists'] = true;

        $v = $this->v->exists();
        $input = __DIR__ . '/../src/valid/readable/file.txt';
        $object = new \SplFileInfo($input);

        $this->assertTrue($v->validate($object));
    }
}