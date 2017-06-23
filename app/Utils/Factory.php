<?php

namespace App\Utils;

use Illuminate\Support\Collection;

/**
 * Class Factory
 *
 * @package App\Utils
 */
class Factory
{
    /**
     * Namespace of the class
     *
     * @var string
     */
    public $namespace;

    /**
     * @param string $namespace
     */
    public function __construct($namespace = '')
    {
        $this->namespace = $namespace;
    }

    /**
     * @param $result
     * @param $closure
     * @return mixed
     */
    public function make($result, $closure)
    {
        $type = !($result instanceof Collection) ? 'Item' : 'Collection';
        $name = $this->namespace . '\\' . $type;

        if (class_exists($name)) {
            return new $name($result, $closure);
        }
    }
}
