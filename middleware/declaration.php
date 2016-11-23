<?php
namespace middleware;

/**
 * not to be called middleware but it sounds nice
 * the main declaration to include in every dependencies
 * in V of MVC
 */

if (!defined('__ROOT__')) define('__ROOT__', dirname(dirname(__FILE__)));

use Controller\Authentication;
use Controller\UserController as UserController;
use Controller\Validation as Validation;
use Controller\Helpers\Methods;
use Controller\Helpers\Debugger;
use IValidation\ValidationInterface;
use Controller\Helpers\Front;
use Controller\FileController;
use Controller\Rendering;

require_once(__ROOT__.'/Controller/Authentication.php');
require_once(__ROOT__.'/Controller/ValidationController.php');
require_once(__ROOT__.'/Controller/UserController.php');
require_once(__ROOT__.'/Controller/Helpers/Debugger.php');
require_once(__ROOT__.'/Controller/Helpers/Methods.php');
require_once(__ROOT__.'/Controller/FileController.php');
require_once(__ROOT__.'/Controller/RenderController.php');

//
//spl_autoload_register(function ($class_name) {
//    include $class_name . '.php';
//    include $ValidationController.'.php';
//    include __DIR__.'\..\Controller\Authentication.php';
//
//});

if(!isset($_SESSION)){
    session_start();
}

?>
