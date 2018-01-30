<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2018/01
 */

namespace Lib\HTTPFoundation;

/**
 * Class HTTPResponse
 *
 * @package Lib\HTTPFoundation
 */
class HTTPResponse
{

    /**
     *
     */
    public static function redirect403()
    {
        header($_SERVER["SERVER_PROTOCOL"] . ' 403 Forbidden');
        echo file_get_contents(ROOT_DIR . '/app/views/Exception/error403.html');
        exit();
    }

    /**
     *
     */
    public static function redirect404()
    {
        header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
        echo file_get_contents(ROOT_DIR . '/app/views/Exception/error404.html');
        exit();
    }
}
