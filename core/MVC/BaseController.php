<?php

namespace Core\MVC;

/**
 * Base controller
 */
abstract class BaseController
{
    /**
     * Before filter - called before an action method.
     *
     * @return void
     */
    protected function before()
    {
    }

    /**
     * After filter - called after an action method.
     *
     * @return void
     */
    protected function after()
    {
    }

    /**
     * Echoes a content to the response and termites execution
     * @param  string  $content      the content of the response
     * @param  string  $content_type the HTTP content type
     * @param  integer $status       the HTTP status cude
     * @return void
     */
    protected function respond(string $content, string $content_type = "text/html", int $status = 200)
    {
        header("Content-Type: ".$content);
        http_response_code($status);
        echo $content;
        die();
    }
}
