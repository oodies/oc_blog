<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2018/01
 */

namespace Lib\Routing;

use Symfony\Component\Validator\Exception\RuntimeException;

/**
 * Class Router
 *
 * @package Lib\Routing
 */
class Router
{
    /** *******************************
     *  CONSTANTS
     */

    const NO_ROUTE = 1;

    /** *******************************
     *  PROPERTIES
     */

    /** @var RouteList */
    protected $routeList;

    /** *******************************
     *  METHODS
     */

    /**
     * Router constructor.
     *
     * @param RouteList $routeList
     */
    public function __construct(RouteList $routeList)
    {
        $this->routeList = $routeList;
    }

    /**
     * @param string $url
     *
     * @throws RuntimeException
     *
     * @return Route
     */
    public function getRoute(string $url)
    {
        /** @var Route $route */
        foreach ($this->routeList->getRoutes() as $index => $route) {
            if (($varValues = $route->match($url)) !== false) {
                if (isset($varValues[1])) {
                    $route->setVars([array_keys($route->getRequirements())[0] => $varValues[1]]);
                }
                return $route;
            };
        }

        throw new \RuntimeException('nothing route', self::NO_ROUTE);
    }
}
