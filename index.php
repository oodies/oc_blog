<?php
/**
 * Created by PhpStorm.
 * User: Sébastien CHOMY
 * Date: 01/12/2017
 * Time: 11:56
 */
session_start();

defined('ROOT_DIR') || define('ROOT_DIR', __DIR__);

require_once ROOT_DIR . '/vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Debug\Debug;
use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/configs/.env');
$env = (getenv('ENV'))??'prod';

if ($env == 'dev') {
    Debug::enable();
    ErrorHandler::register();
    ExceptionHandler::register();
}
// Initialization application
require_once 'Bootstrap.php';
$bootstrap = new Bootstrap();

$bootstrap->init();
// Run application
$bootstrap->dispatch();