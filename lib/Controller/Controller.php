<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */
namespace Lib\Controller;

use Twig_Loader_Filesystem;
use Twig_Environment;
use Psr\Http\Message\ServerRequestInterface;
use GuzzleHttp\Psr7\ServerRequest;

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
     * @param string $path By example 'moduleName:ControllerName:ActionName'
     * @param array  $context An array of parameters to pass to the template
     *
     * @return string The rendered template
     */
    protected function render(string $path, array $context)
    {
        list($module, $controller, $action) = explode(':', $path);

        $directoryApp = $_SERVER['DOCUMENT_ROOT'].'/app/views/layout';
        $directoryModule = $_SERVER['DOCUMENT_ROOT'].'/src/' . $module . '/Presentation/views';

        $loader = new Twig_Loader_Filesystem(array($directoryApp, $directoryModule));
        /** @var Twig_Environment $twig */
        $twig = new Twig_Environment($loader, array(
            'cache' => false
        ));

        $name = $controller . '/' . $action;

        return $twig->render($name, $context);
    }

}