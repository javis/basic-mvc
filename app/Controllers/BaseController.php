<?php
namespace App\Controllers;
use Core\MVC\View;

/**
 * Base controller
 */
abstract class BaseController
{

    static protected function render(string $view, array $args = [])
    {
        // set default arguments
        // check for flash on session
        // remove flash from session
        // create layout view
        // create content view
        // respond
    }

    static protected function flash(string $message, string $type = 'success')
    {
        // create session flash
    }

    /**
     * Echoes a content to the response and termites execution
     * @param  string  $content      the content of the response
     * @param  string  $content_type the HTTP content type
     * @param  integer $status       the HTTP status cude
     * @return void
     */
    static protected function respond(string $content, string $content_type = "text/html", int $status = 200)
    {
        header("Content-Type: ".$content);
        http_response_code($status);
        echo $content;
        die();
    }
}
