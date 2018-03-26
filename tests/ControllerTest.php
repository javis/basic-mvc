<?php
namespace Test;

use Core\MVC\BaseController;

class TestController extends BaseController
{
    public static function test()
    {
        return  "Test";
    }

    public static function test2($param1,$param2='default')
    {
        return $param1;
    }
}

class ControllerTest extends \PHPUnit_Framework_TestCase
{

    public function testMethodIsCallable()
    {
        $this->assertTrue(is_callable([TestController::class,'test']));
        $this->assertEquals(call_user_func([TestController::class,'test']), "Test");
    }

    public function testSupportArgs()
    {
        $this->assertEquals(call_user_func_array([TestController::class,'test2'],[
            'param1'=>'Test',
            'param2'=> 'Wrong',
        ]), "Test");
    }

    public function testSupportOptionalArgs()
    {
        $this->assertEquals(call_user_func_array([TestController::class,'test2'],[
            'param1'=>'Test'
        ]), "Test");
    }
}
