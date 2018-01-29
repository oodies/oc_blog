<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Lib\Controller;

use GuzzleHttp\Psr7\ServerRequest;
use Lib\Registry;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class Controller
 *
 * @package Lib\Controller
 */
class Controller
{
    /**
     * @var ServerRequestInterface
     */
    protected $request = null;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->setRequest();

        return;
    }

    /**
     * @param string $routeName
     * @param array  $params
     *
     * @return string
     */
    public function generateUrl(string $routeName, array $params = null)
    {

        $xml = new \DOMDocument;
        $xml->load(ROOT_DIR . '/configs/routing.xml');

        $routes = $xml->getElementsByTagName('route');

        /** @var \DOMElement $DOMRoute */
        foreach ($routes as $DOMRoute) {
            if ($routeName == $DOMRoute->getAttribute('id')) {
                $path = $DOMRoute->getAttribute('path');

                if (!is_null($params)) {
                    foreach ($params as $param => $value) {
                        $path = str_replace('{' . $param . '}', $value, $path);
                    }
                }
            }
        }

        return $path;
    }

    /**
     * @param string $uri
     */
    public function redirectTo(string $uri)
    {
        $host = $_SERVER['HTTP_HOST'];
        header("Location: http://$host$uri");
    }

    /**
     * @return ServerRequestInterface
     */
    protected function getRequest()
    {
        return $this->request;
    }

    /**
     * Set ServerRequestInterface
     *
     * @return Controller
     */
    protected function setRequest(): Controller
    {
        $this->request = ServerRequest::fromGlobals();
        return $this;
    }

    /**
     * Renders a template.
     *
     * @param string $path    By example 'moduleName:ControllerName:ActionName'
     * @param array  $context An array of parameters to pass to the template
     *
     * @return string The rendered template
     */
    protected function render(
        string $path,
        array $context
    ) {
        list($module, $controller, $action) = explode(':', $path);

        $twig = Registry::get('twig');

        $name = $controller . '/' . $action;

        return $twig->render($name, $context);
    }
}
