<?php

namespace rockunit;


use rock\validate\Validate;
use rockunit\mocks\UploadedMock;

class UploadedTest extends \PHPUnit_Framework_TestCase
{
    /** @var  Validate */
    protected $v;
    protected function setUp()
    {
        $config = [
            'rules' => [
                'uploaded' => [
                    'class' => UploadedMock::className(),
                    'locales' => [
                        'en' => \rock\validate\locale\en\Uploaded::className(),
                        'ru' => \rock\validate\locale\ru\Uploaded::className(),
                    ]
                ],
            ]
        ];
        $this->v = new Validate($config);
    }

    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();
        unset($GLOBALS['is_uploaded_file']);
    }

    public function testValid()
    {
        $GLOBALS['is_uploaded_file'] = true;

        $v = $this->v->uploaded();
        $input = __DIR__ . '/../src/valid/readable/file.txt';
        $this->assertTrue($v->validate($input));
    }

    public function testInvalid()
    {
        $GLOBALS['is_uploaded_file'] = false;

        $v = $this->v->uploaded();
        $input = '/path/of/an/invalid/uploaded/file.txt';
        $this->assertFalse($v->validate($input));
    }

    public function testShouldValidateObjects()
    {
        $GLOBALS['is_uploaded_file'] = true;

        $v = $this->v->uploaded();
        $object = new \SplFileInfo('/path/of/an/uploaded/file');
        $this->assertTrue($v->validate($object));
    }
}