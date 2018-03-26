<?php
namespace App\Controllers;
use Core\MVC\View;

/**
 * Base controller
 */
abstract class BaseController
{
    /**
     * Sets up defaults arguments and layout and prints response with a view
     * @param string $view the template file to render
     * @param array $args the arguments for the view
     */
    static protected function render(string $view, array $args = [])
    {
        // set default arguments
        $default = [
            'title' => 'Books Manager',
            'content' => '',
            'flash' => [],
        ];
        // check for flash on session
        if (isset($_SESSION['flash'])){
            $default['flash'] = $_SESSION['flash'];
            unset($_SESSION['flash']);
        }
        // overwrite defaults with current args
        $args = array_merge($default, $args);
        // create layout view
        $layout = new View('base.html', $args);
        // create content view
        $layout['content'] = new View($view, $args);
        // respond

        self::respond($layout->__toString());
    }

    /**
     * Set a message to be displayed in the view the next time we render one
     * @param  string  $message      the content of the message
     * @param  string  $type         the class to be rendered in the html
     * @return void
     */
    static protected function flash(string $message, string $type = 'success')
    {
        // create session flash
        $_SESSION['flash'][] = [
            'message' => $message,
            'type' => $type
        ];
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
        header("Content-Type: ".$content_type);
        http_response_code($status);
        echo $content;
        die();
    }
}
