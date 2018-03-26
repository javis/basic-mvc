<?php
namespace Test;

use \Core\Router;

class RouterTest extends \PHPUnit_Framework_TestCase
{
    public function testTrue()
    {
        $this->assertTrue(true);
    }

    public function testMapUrl()
    {
        $router = new Router();
        $this->assertEmpty($router->getRoutes());
        $router->add(['get'],'route',function(){ echo 'test'; });
        $this->assertCount(1, $router->getRoutes());
    }

    public function testRoutesConvertedToRegexp()
    {
        $callback = function(){};

        $router = new Router();
        $router->add(['get'],'/',$callback);
        $router->add(['get'],'/books/{id}',$callback);

        $routes = $router->getRoutes();

        $this->assertArrayHasKey('GET',$routes);

        $this->assertArrayHasKey('/^$/i',$routes['GET']);
        $this->assertArrayHasKey('/^books\/(?P<id>[^\]\\"<>^`{|}!$&\'()*+,;=:\/?#[@\s]+)$/i',$routes['GET']);
    }

    public function testMatchRoutes()
    {
        $callback = function(){};

        $router = new Router();
        // test empty path
        $router->add(['get'],'/',$callback);
        $this->assertEquals([$callback, []], $router->route('get','/'));
        $this->assertEquals([$callback, []], $router->route('get',''));
        // test path without normalization
        $router->add(['get'],'/index',$callback);
        $this->assertEquals([$callback, []], $router->route('get','index'));
        // test one argument with custom regexp pattern
        $router->add(['get'],'books/{id:\d*}',$callback);
        $this->assertEquals([$callback, ['id'=>'2']], $router->route('get','/books/2/'));
        // test multiple arguments
        $router->add(['get', 'post'],'{controller}/{action}/{id}',$callback);
        $this->assertEquals([$callback, [
            'controller'=>'books',
            'action'=>'edit',
            'id'=>'2'
        ]], $router->route('post','/books/edit/2'));
    }
}
