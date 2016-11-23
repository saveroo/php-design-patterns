<?php
/**
 * This project solely written in scratch with aim to learn PHP Design Pattern and MVC Architectural
 *  regardless the completness of the result, in the matter of 2 days we learn so much about the fundamental 
 *  to avoid Spaghetti code, at the end we end up making half-baked spaghetti code again due to bunch of homework. 
 *  Heavily inspired by laravel-framework workflow.
 */

/**
 * Created by PhpStorm.
 * User: savero
 * Date: 5/29/2016
 * Time: 11:37 PM
 */


namespace Controller\Helpers;

use Controller\Validation;
use Controller\Authentication;

/**
 * Class Debugger
 * so what i aim is like this
 * Debug::sql
 * Debug::raiseException
 * Debug::showDump
 * Debug::trace
 * @package Controller\Helpers
 */
class Debugger
    {
        public static $session;
        public static $message; 

    /**
     * A Helper just like in laravel.
     * Debugger constructor.
     * @param $data
     * @param null $message
     * @param null $die
     */
    public function __construct($data, $message=null, $die=null)
    {
        $this->prettyDump($data, $message, $die);
    }

    /**
     * @param $data
     * @param null $message
     * @param null $die
     */
    public function prettyDump($data, $message=null, $die=null)
        {

                print '<div class="alert alert-danger">';
                print '<pre>';
                isset($message) ? print '<li>'.$message.'</li>': print 'undefined';
                print '<li>';
                $die === true ? die(var_dump($data)) : var_dump($data);
                print '</li>';
                print '</pre>';
                print '</div>';

        }


    }

/**
 * Class Debug
 * @package Controller\Helpers
 */
class Debug extends  \Exception
{
    /**
     *  Fake-Facade Pattern 
     * @param $data
     * @param null $message
     * @param null $die
     * @return Debugger
     */
    public static function showDump($data, $message=null, $die=null)
    {
        return new Debugger($data, $message, $die);
    }

    /**
     * @param $data
     */
    public static function showError($data)
    {

    }

    /**
     *  To raise an exception and traceback.
     * @param $e
     * @throws Debug
     */
    public static function exception($e)
    {
        print '<div class="alert alert-danger">';
        print '<pre>';
        print '<li>';
        throw new Debug($e);
        print '</li>';
        print '</pre>';
        print '</div>';
    }
}
