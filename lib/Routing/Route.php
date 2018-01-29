<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2018/01
 */

namespace Lib\Routing;

/**
 * Class Route
 *
 * @package Lib\Routing
 */
class Route
{
    /** *******************************
     *  PROPERTIES
     */

    /** @var string $controller Controller name */
    protected $controller;

    /** @var string $action Action name */
    protected $action;

    /** @var string $path template url */
    protected $path;

    /** @var array $requirements An array of require parameters (regexes) */
    protected $requirements;

    /** @var array $vars An array of params values */
    protected $vars = [];

    /** @var string $condition */
    protected $condition;

    /** *******************************
     *  METHODS
     */

    /**
     * Route constructor.
     *
     * @param string $path
     * @param string $controller
     * @param string $action
     */
    public function __construct(string $path, string $controller, string $action)
    {
        $this->path = $path;
        $this->controller = $controller;
        $this->action = $action;
    }

    /**
     * @return string
     */
    public function getController(): string
    {
        return $this->controller;
    }

    /**
     * @param string $controller
     */
    public function setController(string $controller): void
    {
        $this->controller = $controller;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @param string $action
     */
    public function setAction(string $action): void
    {
        $this->action = $action;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    /**
     * @param string $url
     *
     * @return bool|array
     */
    public function match(string $url)
    {
        $path = $this->path;

        if (!empty($this->requirements)) {

            foreach ($this->requirements as $key => $value) {
                if ($value == 'w+') {
                    $value = '[a-zA-Z0-9-]*';
                }
                $path = str_replace('{' . $key . '}', '('.$value.')', $path);
            }
        }

        if (preg_match('%^'.$path.'$%', $url, $matches)) {
            return $matches;
        } else {
            return false;
        }
    }

    /**
     * @return array
     */
    public function getRequirements(): array
    {
        return $this->requirements;
    }

    /**
     * @param array $requirements
     */
    public function setRequirements(array $requirements): void
    {
        $this->requirements = $requirements;
    }

    /**
     * @return bool
     */
    public function hasRequirements(): bool
    {
        return !empty($this->requirements);
    }

    /**
     * @return array
     */
    public function getVars(): array
    {
        return $this->vars;
    }

    /**
     * @param array $vars
     */
    public function setVars(array $vars): void
    {
        $this->vars = $vars;
    }

    /**
     * @return string
     */
    public function getCondition(): string
    {
        return $this->condition;
    }

    /**
     * @param string $condition
     */
    public function setCondition(string $condition): void
    {
        $this->condition = $condition;
    }
}
