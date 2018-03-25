<?php
namespace Core;

/**
 * Router
 */
class Router
{

    /**
     * Handy Singleton to have access to the same instance through the whole app
     * @return [type] [description]
     */
    final public static function getInstance()
    {
        static $instances = array();

        $calledClass = get_called_class();

        if (!isset($instances[$calledClass]))
        {
            $instances[$calledClass] = new $calledClass();
        }

        return $instances[$calledClass];
    }


    /**
     * Array containing the routes registered
     * @var array
     */
    protected $routes = [];


    /**
     * Add a path to the routing table
     * @param array  $methods  list of HTTP methods this route is available in
     * @param string $path     the URL path of the route
     * @param callable $callback the callback for the route
     */
    public function add(array $methods, string $path, callable $callback)
    {
        $route = $this->normalizeRoute($path);

        // Convert the route to a regular expression: escape forward slashes
        $route = preg_replace('/\//', '\\/', $route);

        // Convert variables e.g. {controller}
        // [^\\\]"<>^`{|}!$&'()*+,;=:\/?#[@\s]+
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[^\]\\"<>^`{|}!$&\'()*+,;=:\/?#[@\s]+)', $route);

        // Convert variables with custom regular expressions e.g. {id:\d+}
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);

        // Add start and end delimiters, and case insensitive flag
        $route = '/^' . $route . '$/i';

        foreach($methods as $method){
            $this->routes[strtoupper($method)][$route] = $callback;
        }
    }

    /**
     * Get all the routes from the routing table
     *
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * tries to match an url to a registered route and returns an array with
     * the associated callback and parsed arguments found in the matched route
     * @param  string $method the HTTP method to match
     * @param  string $url the url to match
     * @return array  [callbach,params]
     */
    public function route(string $method, string $url) : ?array
    {
        $routes = $this->getRoutes();

        $url = $this->normalizeRoute($url);

        // filter by method
        $routes = $routes[strtoupper($method)]??[];

        // search for a route to match
        foreach ($routes as $route => $callback) {
            if (preg_match($route, $url, $matches)) {
                $params = [];

                // Get named capture group values
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                }

                return [$callback, $params];
            }
        }

        return null;
    }

    /**
     * normalizes a URL path
     * @param  string $url the path to normalize
     * @return string the normalized path
     */
    protected function normalizeRoute(string $url) : string
    {
        $url = trim($url,"\t\n\r\0\x0B/");
        return $url;
    }
}
