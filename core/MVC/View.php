<?php

namespace Core\MVC;

/**
 * A View renders a template file using the values stored in the object
 */
class View extends \ArrayObject
{
    protected $base_path;
    protected $view;

    static $app_path;

    public static function setAppPath(string $path)
    {
        self::$app_path = $path;
    }

    /**
     * @param string $view      Path to the template file
     * @param array  $args      Optional initial values to use when rendering the object
     * @param string $base_path Optional base path where to look for the template files
     */
    public function __construct(string $view, array $args = [], string $base_path = "app/Views"){
        parent::__construct($args);

        $this->view = $view;
        $this->base_path = $base_path;

        $file = $this->getFilePath();  // relative to Core directory
        if (!is_readable($file)) {
            throw new \Exception("View file \"$file\" not found");
        }
    }

    /**
     * returns the path to the View file
     * @var [type]
     */
    protected function getFilePath() : string
    {
        return   self::$app_path . "/{$this->base_path}/{$this->view}";
    }


    /**
     * Echoes the view content
     * @return mixed
     */
    public function render()
    {
        $args = $this->getArrayCopy();

        // copy all args to contained view objects
        array_walk($args, function(&$value, $key){
            if (is_object($value) and is_a($value,self::class)) {
                $value = clone $value;
                foreach ($this as $key1 => $value1) {
                    if (!$value->offsetExists($key1)) {
                       $value->offsetSet($key1,$value1);
                    }
                }
            }
        });

        return $this->clousureInclude($this->getFilePath(), $args);
    }

    /**
     * provides an enclosed environment for the view to be executed
     * @param  [type] $path  [description]
     * @param  [type] $array [description]
     * @return [type]        [description]
     */
    protected function clousureInclude($path, $array)
    {
        return call_user_func(function() use ($path,$array) {
            extract($array);
            return include($path);
        });
    }

    /**
     * Returns the rendered view as string
     * @return string The view content
     */
    public function __toString() {
        ob_start();
        try {
            $this->render();
        } catch (Throwable $e) {
            ob_end_clean();
            throw $e;
        }
        $return = ob_get_contents();
        ob_end_clean();
        return $return;
    }


    public function get ( mixed $key , mixed $default = null )
    {
        return parent::get($key,$default);
    }


}
