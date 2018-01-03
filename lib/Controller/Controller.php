<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Lib\Controller;

use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ServerRequestInterface;
use Twig_Loader_Filesystem;
use Twig_Environment;
use Twig_Extension_Debug;

/**
 * Class Controller
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
     * @return ServerRequestInterface
     */
    protected function getRequest()
    {
        return $this->request;
    }

    /**
     * Set ServerRequestInterface
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
    protected function render(string $path, array $context)
    {
        list($module, $controller, $action) = explode(':', $path);

        $directoryApp = $_SERVER['DOCUMENT_ROOT'] . '/app/views/layout';
        $directoryModule = $_SERVER['DOCUMENT_ROOT'] . '/src/' . $module . '/Presentation/views';

        if (getenv('ENV') == 'dev') {
            $options = [
                'cache' => false,
                'debug' => true
            ];
        } else {
            $options = ['cache' => true];
        }

        $loader = new Twig_Loader_Filesystem(array($directoryApp, $directoryModule));
        /** @var Twig_Environment $twig */
        $twig = new Twig_Environment($loader, $options);

        if (getenv('ENV') == 'dev') {
            $twig->addExtension(new Twig_Extension_Debug());
        }

        $name = $controller . '/' . $action;

        return $twig->render($name, $context);
    }
}