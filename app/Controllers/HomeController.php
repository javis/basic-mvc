<?php
namespace App\Controllers;
use Core\MVC\{BaseController, View};

class HomeController extends BaseController
{
    public static function index()
    {

        $layout = new View('layout.html',[
            'title'=>'Page Title',
            'user' => 'JAvier'
        ]);

        $content = new View('content.html', ['title' => 'Another Title']);

        $layout['content'] = $content;


        $layout->render();

    }
}
