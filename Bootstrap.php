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

    /** @var array */
    protected $route;

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
        $this->initRoute();
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

        /** @var \Lib\Db\Adapter\PdoMysql $db */
        $dbAdapter = DbFactory::create($adapter, $config['DB']);

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

        $srcDir = new DirectoryIterator(__DIR__.'/src');
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
     *
     */
    protected function initRoute()
    {

        $this->route = [
            // Blogpost routing
            //
            'app_dashboard_index'           => [
                'path'       => '/admin',
                'controller' => 'app:dashboard:index',
                'allow'      => 'admin',
            ],
            'blogpost_get_blogposts'        => [
                'path'       => '/posts',
                'controller' => 'blogpost:getBlogposts:getBlogposts',
                'allow'      => 'guest',
            ],
            'blogpost_get_blogpost'         => [
                'path'       => '/post',
                'controller' => 'blogpost:getBlogpost:getBlogpost',
                'allow'      => 'guest',
            ],
            'blogpost_post_blogpost'        => [
                'path'       => '/newPost',
                'controller' => 'blogpost:postBlogpost:postBlogpost',
                'allow'      => 'blogger',
            ],
            'blogpost_put_blogpost'         => [
                'path'       => '/changePost',
                'controller' => 'blogpost:putBlogpost:putBlogpost',
                'allow'      => 'blogger',
            ],
            'blogpost_management_postList'  => [
                'path'       => '/admin/posts',
                'controller' => 'blogpost:management:getPosts',
                'allow'      => 'admin',
            ],
            'blogpost_management_enabled'   => [
                'path'       => '/admin/post/enabled',
                'controller' => 'blogpost:management:enabled',
                'allow'      => 'admin',
            ],
            'blogpost_management_disabled'  => [
                'path'       => '/admin/post/disabled',
                'controller' => 'blogpost:management:disabled',
                'allow'      => 'admin',
            ],
            // Users registration routing
            //
            'user_registration_register'    => [
                'path'       => '/registration',
                'controller' => 'user:registration:register',
                'allow'      => 'guest',
            ],
            // Users security routing
            //
            'user_security_login'           => [
                'path'       => '/login',
                'controller' => 'user:security:login',
                'allow'      => 'guest',
            ],
            'user_security_logout'          => [
                'path'       => '/logout',
                'controller' => 'user:security:logout',
                'allow'      => 'guest',
            ],
            // Users management routing
            //
            'user_management_getUser'       => [
                'path'       => '/admin/user',
                'controller' => 'user:management:getUser',
                'allow'      => 'admin',
            ],
            'user_management_users'         => [
                'path'       => '/admin/users',
                'controller' => 'user:management:getUsers',
                'allow'      => 'admin',
            ],
            'user_management_postUser'      => [
                'path'       => '/admin/addUser',
                'controller' => 'user:management:postUser',
                'allow'      => 'admin',
            ],
            'user_management_putUser'       => [
                'path'       => '/admin/changeUser',
                'controller' => 'user:management:putUser',
                'allow'      => 'admin',
            ],
            'user_management_lock'          => [
                'path'       => '/admin/user/lock',
                'controller' => 'user:management:lock',
                'allow'      => 'admin',
            ],
            'user_management_unlock'        => [
                'path'       => '/admin/user/unlock',
                'controller' => 'user:management:unlock',
                'allow'      => 'admin',
            ],
            // Comment routing
            //
            'comment_comments_list'         => [
                'path'       => '/comments',
                'controller' => 'comment:getComments:getThread',
                'allow'      => 'admin',
            ],
            'comment_management_comments'   => [
                'path'       => '/admin/comments',
                'controller' => 'comment:management:getComments',
                'allow'      => 'admin',
            ],
            'comment_management_approve'    => [
                'path'       => '/admin/comment/approve',
                'controller' => 'comment:management:approve',
                'allow'      => 'admin',
            ],
            'comment_management_disapprove' => [
                'path'       => '/admin/comment/disapprove',
                'controller' => 'comment:management:disapprove',
                'allow'      => 'admin',
            ],
            'comment_management_putComment' => [
                'path'       => '/admin/comment/change',
                'controller' => 'comment:management:putComment',
                'allow'      => 'admin',
            ],
            'comment_comments_new'          => [
                'path'       => '/newComment',
                'controller' => 'comment:postComment:postComment',
                'allow'      => 'guest',
            ],
            // Other application routing
            'contact'                       => [
                'path'       => '/contact',
                'controller' => 'app:contactUs:contactUs',
                'allow'      => 'guest',
            ],
            'homepage'                      => [
                'path'       => '/',
                'controller' => 'app:homepage:homepage',
                'allow'      => 'guest',
            ],
        ];
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

        Registry::getInstance()->set('DIC', $DIC);
    }

    /**
     *
     */
    public function dispatch()
    {
        $path = $this->request->getUri()->getPath();

        // default route
        $route = [
            'path'       => '/',
            'controller' => 'app:homepage:homepage',
            'allow'      => 'guest',
        ];
        foreach ($this->route as $index => $paramRoute) {
            if ($paramRoute['path'] === $path) {
                $route = $paramRoute;
                break;
            }
        }

        // Default role
        if (!isset($_SESSION['roles'])) {
            $_SESSION['roles'] = ['guest'];

            Auth::getInstance()->setStorage();
        }

        if (in_array($route['allow'], $_SESSION['roles'])) {

            list($module, $controller, $action) = explode(':', $route['controller']);

            $class = ucfirst($module) . '\Presentation\Controller' . '\\' . ucfirst($controller);
            $myClass = new $class();
            $action = $action . 'Action';

            $myClass->$action();
        } else {
            echo 'Unauthorized action';
        }
    }
}
