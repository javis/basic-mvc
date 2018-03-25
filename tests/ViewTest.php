<?php
namespace Test;

use Core\MVC\View;

class ViewTest extends \PHPUnit_Framework_TestCase
{
    public function __construct()
    {
        View::setAppPath(APP_ROOT);
    }

    public function testRenderSingleView()
    {
        $view = new View('layout.html',[
            'title' => 'Test',
            'content' => ''
        ],'tests/assets');

        $this->assertEquals("<h1>Test</h1>",trim($view->__toString()));
    }

    public function testRenderContentView()
    {
        $content = new View('content.html', [], 'tests/assets');

        $view = new View('layout.html',[
            'title' => 'Test',
            'content' => $content
        ],'tests/assets');

        $this->assertEquals("<h1>Test</h1>Test",trim($view->__toString()));
    }

    public function testContentOverridesArgs()
    {
        $content = new View('content.html', [
            'title' => 'Other Value'
        ], 'tests/assets');

        $view = new View('layout.html',[
            'title' => 'Test',
            'content' => $content
        ],'tests/assets');

        $this->assertEquals("<h1>Test</h1>Other Value",trim($view->__toString()));
    }
}
