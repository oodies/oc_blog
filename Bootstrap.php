<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

use GuzzleHttp\Psr7\ServerRequest;
use Lib\Db\DbFactory;
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

    /** @var ServerRequestInterface\ */
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
        $this->initRequest();
        $this->initRoute();
    }


    /**
     * Initialization connection database
     *
     * @throws Exception
     */
    protected function initDb()
    {
        $adapter = 'Pdo_Mysql';

        $config = \parse_ini_file(ROOT_DIR . '/configs/application.ini', true);

        if (false === $config) {
            throw new \Exception('Error while reading configuration parameters');
        }

        /** @var \Lib\Db\Adapter\Pdo_Mysql $db */
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
     *
     */
    protected function initRequest()
    {
        $request = \GuzzleHttp\Psr7\ServerRequest::fromGlobals();
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
            'blogpost_get_blogposts'     => [
                'path'       => '/posts',
                'controller' => 'blogpost:getBlogposts:getBlogposts'
            ],
            'blogpost_get_blogpost'      => [
                'path'       => '/post',
                'controller' => 'blogpost:getBlogpost:getBlogpost',
            ],
            'blogpost_post_blogpost'     => [
                'path'       => '/newPost',
                'controller' => 'blogpost:postBlogpost:postBlogpost'
            ],
            'blogpost_put_blogpost'      => [
                'path'       => '/changePost',
                'controller' => 'blogpost:putBlogpost:putBlogpost',
            ],
            // Users registration routing
            //
            'user_registration_register' => [
                'path'       => '/registration',
                'controller' => 'user:registration:register'
            ],
            // Users security routing
            //
            'user_security_login'        => [
                'path'       => '/login',
                'controller' => 'user:security:login'
            ],
            'user_security_logout'       => [
                'path'       => '/logout',
                'controller' => 'user:security:logout'
            ],
            // Users management routing
            //
            'user_management_getUser'      => [
                'path'       => '/admin/user',
                'controller' => 'user:management:getUser'
            ],
            'user_management_users'      => [
                'path'       => '/admin/users',
                'controller' => 'user:management:getUsers'
            ],
            'user_management_postUser'    => [
                'path'       => '/admin/addUser',
                'controller' => 'user:management:postUser',
            ],
            'user_management_putUser'    => [
                'path'       => '/admin/changeUser',
                'controller' => 'user:management:putUser',
            ],
            'user_management_lock'    => [
                'path'       => '/admin/user/lock',
                'controller' => 'user:management:lock',
            ],
            'user_management_unlock'    => [
                'path'       => '/admin/user/unlock',
                'controller' => 'user:management:unlock',
            ],
            // Comment routing
            //
            'comment_comments_list'      => [
                'path'       => '/comments',
                'controller' => 'comment:getComments:getThread'
            ],
            'comment_management_comments'      => [
                'path'       => '/admin/comments',
                'controller' => 'comment:management:getComments'
            ],
            'comment_comments_new'       => [
                'path'       => '/newComment',
                'controller' => 'comment:postComment:postComment'
            ],
            // Other application routing
            'contact'                    => [
                'path'       => '/contact',
                'controller' => 'app:contactUs:contactUs'
            ],
            'homepage'                   => [
                'path'       => '/',
                'controller' => 'app:homepage:homepage'
            ]
        ];
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
            'controller' => 'blogpost:getBlogposts:getBlogposts'
        ];
        foreach ($this->route as $index => $paramRoute) {
            if ($paramRoute['path'] === $path) {
                $route = $paramRoute;
                break;
            }
        }
        list($module, $controller, $action) = explode(':', $route['controller']);

        $class = ucfirst($module) . '\Presentation\Controller' . '\\' . $controller;
        $myClass = new $class();
        $action = $action . 'Action';

        $myClass->$action();
    }
}