<?php
/**
 * Created by PhpStorm.
 * User: Sébastien CHOMY
 * Date: 01/12/2017
 * Time: 11:56
 */

defined('ROOT_DIR') || define('ROOT_DIR', __DIR__);

require_once ROOT_DIR . '/vendor/autoload.php';

// Initialization application
require_once 'Bootstrap.php';
$bootstrap = new Bootstrap();

$bootstrap->init();
// Run application
$bootstrap->dispatch();