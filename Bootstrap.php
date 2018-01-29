<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

use GuzzleHttp\Psr7\ServerRequest;
use Lib\Db\DbFactory;
use Lib\Auth;
use Lib\DIC;
use Lib\Registry;
use Psr\Http\Message\ServerRequestInterface;
use Lib\Routing\Route;
use Lib\Routing\RouteList;
use Lib\Routing\Router;

/**
 * Class Bootstrap
 */
class Bootstrap
{

    /** *******************************
     *     PROPERTIES
     */

    /** @var ServerRequestInterface */
    protected $request;

    /** @var Router */
    protected $router;

    /** *******************************
     *      METHODS
     */

    /**
     * Main init
     */
    public function init()
    {
        $this->initDb();
        $this->initView();
        $this->initAuth();
        $this->initRequest();
        $this->initRouter();
        $this->initService();
    }

    /**
     * Initialization connection database
     *
     * @throws Exception
     */
    protected function initDb()
    {
        $adapter = 'PdoMysql';

        $config = \parse_ini_file(ROOT_DIR . '/configs/application.ini', true);

        if (false === $config) {
            throw new \Exception('Error while reading configuration parameters');
        }

        try {
            /** @var \Lib\Db\Adapter\PdoMysql $db */
            $dbAdapter = DbFactory::create($adapter, $config['DB']);
        } catch (RuntimeException $e) {
            echo $e->getMessage();
        }

        try {
            // connection attempt
            $dbAdapter->getConnection();
        } catch (\PDOException $e) {
            die("Probably wrong identifiers, or the DBMS is not reachable: " . $e->getMessage());
        }

        // Set the adapter database to a registry
        Registry::set('db', $dbAdapter);
    }

    /**
     * Initialization twig environment
     */
    protected function initView()
    {
        $directories[] = $_SERVER['DOCUMENT_ROOT'] . '/app/views/layout';

        $srcDir = new DirectoryIterator(__DIR__ . '/src');
        foreach ($srcDir as $fileInfo) {
            if ($fileInfo->isDir() && !$fileInfo->isDot()) {
                $boundedContext = $fileInfo->getFilename();
                $directories[] = $_SERVER['DOCUMENT_ROOT'] . '/src/' . $boundedContext . '/Presentation/views';
            }
        }

        if (getenv('ENV') == 'dev') {
            $options = [
                'cache' => false,
                'debug' => true,
            ];
        } else {
            $options = [];
        }

        $loader = new Twig_Loader_Filesystem($directories);
        /** @var Twig_Environment $twig */
        $twig = new Twig_Environment($loader, $options);

        if (getenv('ENV') == 'dev') {
            $twig->addExtension(new Twig_Extension_Debug());
        }

        Registry::set('twig', $twig);
    }

    /**
     * Persist $_SESSION in Auth object
     */
    protected function initAuth()
    {
        /** @var Auth $auth */
        Auth::getInstance()->setStorage();
    }

    /**
     *
     */
    protected function initRequest()
    {
        $request = ServerRequest::fromGlobals();
        $this->request = $request;

        // Set the global information request to a registry
        Registry::set('request', $request);
    }

    /**
     * Set router property with Router class
     */
    protected function initRouter()
    {
        $xml = new \DOMDocument;
        $xml->load(ROOT_DIR . '/configs/routing.xml');

        $routes = $xml->getElementsByTagName('route');

        $routeList = new RouteList();

        /** @var  $DOMRoute DOMElement */
        foreach ($routes as $DOMRoute) {
            $attrController = $DOMRoute->getAttribute('controller');
            list($controller, $action) = explode('::', $attrController);

            /** @var Route $route */
            $route =
                new Route(
                    $DOMRoute->getAttribute('path'),
                    $controller,
                    $action
                );

            if ($DOMRoute->hasChildNodes()) {
                /** @var \DOMElement $node */
                $requirements = [];
                foreach ($DOMRoute->childNodes as $node) {
                    if ($node->nodeType === XML_ELEMENT_NODE && $node->nodeName === "requirement") {
                        $requirements[$node->getAttribute('key')] = $node->nodeValue;
                    }
                    if ($node->nodeType === XML_ELEMENT_NODE && $node->nodeName === "condition") {
                        $route->setCondition($node->nodeValue);
                    }
                }
                $route->setRequirements($requirements);
            }

            $routeList->offsetSet(
                $DOMRoute->getAttribute('id'),
                $route
            );
        }

        $this->router = new Router($routeList);
    }

    /**
     *
     */
    protected function initService()
    {
        $DIC = new DIC();
        $DIC->set(
            'userService', function () {
            return new User\Infrastructure\Service\UserService();
        }
        );

        Registry::set('DIC', $DIC);
    }

    /**
     * use router property
     */
    public function dispatch()
    {
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = Registry::get('request');
        try {
            /** @var Route $matchedRoute */
            $matchedRoute = $this->router->getRoute($request->getUri()->getPath());

            // Default role
            if (!isset($_SESSION['roles'])) {
                $_SESSION['roles'] = ['guest'];
                Auth::getInstance()->setStorage();
            }

            if (in_array($matchedRoute->getCondition(), $_SESSION['roles'])) {

                $controller = $matchedRoute->getController();
                $myClass = new $controller;
                $action = $matchedRoute->getAction() . 'Action';
                // Dispatch
                $myClass->$action(implode(',', array_values($matchedRoute->getVars())));
            } else {
                // TODO Unauthorized Page
                echo 'Unauthorized action';
            }
        } catch (\RuntimeException $e) {
            // TODO Error 404
            echo 'Unknown page';
        }
    }
}
