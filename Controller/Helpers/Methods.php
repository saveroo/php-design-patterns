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
 * Date: 5/30/2016
 * Time: 12:53 AM
 */

namespace Controller\Helpers;


/**
 * Class Methods
 *
 * A Helper class like showing
 * Front::welcomeShow
 * Front::redirect
 * Front::render and else
 * @package Controller\Helpers
 */
class Methods
{
    /**
     * Methods constructor.
     */
    public function __construct()
    {
        $this->Welcome();
    }

    /**
     * @return string
     */
    public function Welcome()
    {
        if(isset($_SESSION))
        {
            return "Welcome ".$_SESSION['login']['username'];
        }
    }

    /**
     * Mysqli real escaping for +5 value on account regarding security of such sql injection
     * @param $input
     * @param $connection
     * @return mixed
     */
    public static function escape($input, $connection)
    {
        $new1='';
        if(is_array($input)){
        foreach ($input as $k => $v)
        {
            $new1[$k] = mysqli_real_escape_string($connection,$v);
        }
        return $new1;
        }
        return $input;
    }
}

class Messaging{

    protected static $instance;
    public $message;

    public static function getInstance()
    {
        if(self::$instance==null)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct()
    {

    }

    public static function pull($name)
    {
        return $this->show($name);
    }

    public function set($name, $msg)
    {
        $this->message[$name] = $msg;
        $_SESSION['msg'][$name] = $msg;
    }

    public function show($name)
    {
        if(isset($_SESSION['msg']))
       return $_SESSION['msg'][$name];
        return false;
    }
}

/**
 * Class Front
 * @package Controller\Helpers
 */
class Front
{


    /**
     * not complete yet
     * @return Methods
     */
    public static function showWelcome()
    {
        return new Methods();
    }

    /**
     * redirect with HTML meta so header problem wont bother
     * @param $link
     * @return string
     */
    public static function redirect($link)
    {
        print '<meta http-equiv="refresh" content="0;url='.$link.'">';
//        return header("refresh:0;url=$link");
    }

    public static function pushMessage($name, $msg)
    {
        $construct = new Messaging();
        $construct->set($name, $msg);
        $show = $construct->show($name);
        echo "<div class='alert alert-info'>$show</div>";
    }

    public static function pullMessage($name='')
    {
        $msg = Messaging::getInstance();
        if(isset($_SESSION['msg'][$name]))
        {
            $show = $msg->show($name);
            echo "<div class=\"alert alert-info \">Last action: $show</div>";
        }elseif(isset($_SESSION['msg']) && $name == null)
        {
            foreach ($_SESSION['msg'] as $a => $b)
            {
                echo "<div class=\"alert alert-info \">Last action: [$a] $b</div>";
            }
        }
    }

    public static function countCart()
    {
        if(isset($_SESSION['login']['cart']))
        {
            echo count($_SESSION['login']['cart']);
        }else
        {
            return 0;
        }
    }
}