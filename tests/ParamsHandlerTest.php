<?php

require_once('src/ParamsHandler.php');

use PHPUnit\Framework\TestCase;

final class ParamsHandlerTest extends TestCase
{

    public function testGetParamExists()
    {
        $_GET = array(
            'param1' => 'value1',
            'param2' => 'value2',
            'param3' => array(
                'subkey1' => 'subvalue1',
            )
        );

        $pm = new ParamsHandler();

        $this->assertEquals($pm->get('param1'), 'value1');
    }

    public function testGetParamNotExists()
    {
        $_GET = array(
            'param1' => 'value1',
            'param2' => 'value2',
            'param3' => array(
                'subkey1' => 'subvalue1',
            )
        );

        $pm = new ParamsHandler();

        $this->assertEquals($pm->get('param4', false), false);
    }


    public function testPostParamExists()
    {
        $_POST = array(
            'param1' => 'value1',
            'param2' => 'value2',
            'param3' => array(
                'subkey1' => 'subvalue1',
            )
        );

        $pm = new ParamsHandler();

        $this->assertEquals($pm->post('param1'), 'value1');
    }

    public function testPostParamNotExists()
    {
        $_POST = array(
            'param1' => 'value1',
            'param2' => 'value2',
            'param3' => array(
                'subkey1' => 'subvalue1',
            )
        );

        $pm = new ParamsHandler();

        $this->assertEquals($pm->post('param4', false), false);
    }

    public function testParamsExists()
    {
        $_POST = array(
            'param1' => 'value1',
            'param2' => 'value2',
            'param3' => array(
                'subkey1' => 'subvalue1',
            )
        );

        $_GET = array(
            'param4' => 'value1',
            'param5' => 'value2',
            'param6' => array(
                'subkey1' => 'subvalue1',
            )
        );

        $pm = new ParamsHandler();
        $this->assertEquals($pm->params('param1'), 'value1');
        $this->assertEquals($pm->params('param5'), 'value2');
    }

    public function testParamsNotExists()
    {
        $_POST = array(
            'param1' => 'value1',
            'param2' => 'value2',
            'param3' => array(
                'subkey1' => 'subvalue1',
            )
        );

        $_GET = array(
            'param4' => 'value1',
            'param5' => 'value2',
            'param6' => array(
                'subkey1' => 'subvalue1',
            )
        );

        $pm = new ParamsHandler();
        $this->assertEquals($pm->params('param10'), false);
    }

    public function testSingleFile()
    {
        $upload = array(
            'name' => 'test.jpg',
            'tmp_name' => 'tmp0001.tmp',
            'error' => 0,
            'type' => 'image/jpg',
            'size' => 1024
        );
        $_FILES = array(
            'upload' => $upload
        );


        $pm = new ParamsHandler();
        $this->assertEquals($pm->file('upload'), $upload, "\$canonicalize = true", $delta = 0.0, $maxDepth = 10, $canonicalize = true);

    }

    public function testMultipleFile()
    {
        $upload = array(
            'name' => array('test.jpg'),
            'tmp_name' => array('tmp0001.tmp'),
            'error' => array(0),
            'type' => array('image/jpg'),
            'size' => array(1024)
        );

        $_FILES = array(
            'upload' => $upload
        );

        $shouldBe = array(
            array(
                'name' => 'test.jpg',
                'tmp_name' => 'tmp0001.tmp',
                'error' => 0,
                'type' => 'image/jpg',
                'size' => 1024
            )
        );


        $pm = new ParamsHandler();
        $this->assertEquals($pm->file('upload'), $shouldBe, "\$canonicalize = true", $delta = 0.0, $maxDepth = 10, $canonicalize = true);

    }

    public function testFileNotExists()
    {
        $upload = array(
            'name' => 'test.jpg',
            'tmp_name' => 'tmp0001.tmp',
            'error' => 0,
            'type' => 'image/jpg',
            'size' => 1024
        );
        $_FILES = array(
            'upload' => $upload
        );


        $pm = new ParamsHandler();
        $this->assertEquals($pm->file('uploadnothing'), false);

    }
}
