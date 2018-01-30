<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2018/01
 */

namespace Lib\Routing;

/**
 * Class RouteList
 *
 * @package Lib\Routing
 */
class RouteList implements \ArrayAccess
{
    /** *******************************
     * PROPERTIES
     */

    /**
     * @var array
     */
    private $routes = [];

    /** *******************************
     * METHODS
     */

    /**
     * Whether a offset exists
     *
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    /**
     * @param $offset
     *
     * @return bool
     */
    public function has($offset)
    {
        return isset($this->routes[$offset]);
    }

    /**
     * Offset to retrieve
     *
     * @param mixed $offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * @param $offset
     *
     * @return mixed
     */
    public function get($offset)
    {
        if (!isset($this->routes[$offset])) {
            throw new \OutOfBoundsException(sprintf('The offset "%s" does not exist.', $offset));
        }

        return $this->routes[$offset];
    }

    /**
     * Offset to set
     *
     * @param mixed $offset
     * @param mixed $route
     */
    public function offsetSet($offset, $route)
    {
        if (null === $offset) {
            $this->add($route);
            return;
        }
        $this->set($offset, $route);
    }

    /**
     * @param $route
     */
    public function add($route)
    {
        $this->routes[] = $route;
    }

    /**
     * @param $offset
     * @param $route
     */
    public function set($offset, $route)
    {
        $this->routes[$offset] = $route;
    }

    /**
     * Offset to unset
     *
     * @param mixed value $offset
     */
    public function offsetUnset($offset)
    {
        unset ($this->routes[$offset]);
    }

    /**
     * Count elements of an object
     *
     * @return int
     */
    public function count()
    {
        return count($this->routes);
    }

    /**
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }

}
