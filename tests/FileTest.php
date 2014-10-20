<?php

namespace rockunit\validate;




use rock\validate\Validate;
use rockunit\mocks\FileMock;

class FileTest extends \PHPUnit_Framework_TestCase
{
    /** @var  Validate */
    protected $v;
    protected function setUp()
    {
        $config = [
            'rules' => [
                'file' => [
                    'class' => FileMock::className(),
                    'locales' => [
                        Validate::EN => \rock\validate\locale\en\File::className(),
                        Validate::RU => \rock\validate\locale\ru\File::className(),
                    ]
                ],
            ]
        ];
        $this->v = new Validate($config);
    }

    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();
        unset($GLOBALS['is_file']);
    }

    public function testValid()
    {
        $GLOBALS['is_file'] = true;

        $v = $this->v->file();
        $input = __DIR__ . '/../src/valid/readable/file.txt';
        $this->assertTrue($v->validate($input));
    }

    public function testInvalid()
    {
        $GLOBALS['is_file'] = false;

        $v = $this->v->file();
        $input = __DIR__ . '/../src/invalid/readable/file.txt';
        $this->assertFalse($v->validate($input));
    }

    public function testShouldValidateObjects()
    {
        $v = $this->v->file();
        $object = $this->getMock('SplFileInfo', ['isFile'], ['somefile.txt']);
        $object->expects($this->once())
                ->method('isFile')
                ->will($this->returnValue(true));

        $this->assertTrue($v->validate($object));
    }
}