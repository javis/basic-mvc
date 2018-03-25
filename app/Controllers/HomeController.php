<?php
namespace App\Controllers;
use Core\MVC\BaseController;

class HomeController extends \BaseController
{
    public static function index()
    {

        $layout = new Core\MVC\View('layout.html',[
            'title'=>'Page Title',
            'user' => 'JAvier'
        ]);

        $content = new Core\MVC\View('content.html', ['title' => 'Another Title']);

        $layout['content'] = $content;


        $layout->render();

    }
}
