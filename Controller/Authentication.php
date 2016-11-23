<?php

namespace Controller;

use Controller\DatabaseController as db;
use Controller\Helpers\Debug;

require_once('DatabaseController.php');


/**
 * Class Authentication
 *
 * Basically what i want is like this
 * Auth::grant([@param]) >> page granting
 * Auth::revoke >> revoke access
 * Auth::role >> check role
 * Auth::check >> check storage session and else
 * Auth::redirect >> redirect to new page
 * Auth::restrict >> restrict access
 * Auth::grantThese >> grant certain feature
 * @package Controller
 */
class Authentication
{
    protected $username = '';
    protected $password = '';
    public $role;
    protected $cookieObject;
    protected $user = array();
    protected $instance = null;
    public $status = false;
    public $session;

    public $call;

//    public $status;

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param $role
     * @return mixed
     */
    public function setRole($role)
    {
        return $this->role = $role;
    }

    /**
     * @return mixed
     */
    public function getCookie()
    {
        return $this->getCookieObject();
    }

    /**
     * Setcookie every remember tick
     */
    public function setCookie()
    {
        return $this->setCookieObject(setcookie('login', base64_encode($this->getUsername()) . ':' . base64_encode($this->getRole()), time() + 3600));
    }

    /**
     *  The main session role grant.
     * @param $name
     * @param $value
     * @return bool
     */
    public function setSession($name, $value)
    {
        if($this->checkRole() != null) {
            $_SESSION['login'][$name] = $value;
            $_SESSION['login']['role'] = $this->checkRole();
            if (isset($_SESSION[$name])) {
                $this->s = $_SESSION['login'];
                return true;
            }
        }
        return false;
    }

    /**
     *  Getting session
     * @return mixed
     */
    public function getSession()
    {
        if($_SESSION['login']['role'] == null) {
        } else {
            return $_SESSION['login']['role'];
        }
    }

    /**
     *  to check role on database upon user $_POST
     * @return mixed
     */
    public function checkRole()
    {
        $hashed = md5($this->getPassword());
        $query = "SELECT usertype FROM users WHERE username='{$this->getUsername()}' and password='{$hashed}'";
        $row = $this->call->make()->query($query)->fetch_array(MYSQLI_BOTH);

//        Debug::showDump($row);
        if ($row) {
            $this->setRole($row['usertype']);
            return $row['usertype'];
        }
    }

    /**
     *  The main spagheti method
     * @param $data
     * @return bool|mixed
     */
    public function validation($data)
    {

        $hashed = md5($data['password']);
        $query = "SELECT * FROM users WHERE username='{$data['username']}' and password='{$hashed}'";
        $get = $this->call->make()->query($query)->num_rows;
//        Debug::showDump($get);

        if($get>0)
        {
            $row = $this->call->make()->query($query)->fetch_array(MYSQLI_BOTH);
            $this->setUsername($row['username']);
            $this->setPassword($data['password']);
            $this->setStatus(true);
            return $this->getStatus();

        }
        else
        {
            $this->setStatus(false);
            print "[f:VLDTN]: User doesnt exists or your password is wrong";
            return false;

        }

//        if ($row) {
//            if ($this->setSession('username', $this->getUsername())) {
//                $this->setStatus(true);
//            } else {
//                return false;
//            }
//        } else {
//            $this->setStatus(false);
//            return print "[f:Validation]: Data doesnt exists in the database ";
//
//        }
    }

    /**
     *  Not used atm.
     * Comparing db user
     * @param $u
     * @param $p
     * @return bool|int
     */
    public function compareDBuser($u, $p)
    {
        $hashed = md5($p);
        $query = "SELECT * FROM users WHERE username='{$u}' and password='{$hashed}'";
        $row = $this->fetchData($query);

        if ($row) {
            $this->setStatus(true);
            return true;
        } else {
            $this->setStatus(false);
            return print "[f:CPDbUSER]: Data doesnt exists in the database ";

        }
    }

    /**
     * Authentication constructor.
     * @param null $u
     * @param null $p
     * @param null $cook
     */
    public function __construct($u=null, $p=null, $cook=null)
    {

        $this->call = DbProto::getInstance();

        if (is_array($u)){
            if(array_key_exists('username', $u) && array_key_exists('password', $u))
            {
                if($this->validation($u) == true);
                {
                    $this->setSession('username', $u['username']);
                    if (array_key_exists('remember', $u)){
                        $this->setCookie();
                    }
                }
            }

        }

    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }


    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        return $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getCookieObject()
    {
        return $this->cookieObject;
    }

    /**
     * @param mixed $cookieObject
     */
    public function setCookieObject($cookieObject)
    {
        $this->cookieObject = $cookieObject;
    }
}

/*
 *
 *
 * Facade class so no need to overhaul spagheti method above.
 */

/**
 * Class Auth
 * @package Controller
 */
class Auth
{
    /**
     * @var
     */
    public static $param;

    /**
     * @return Auth
     */
    public static function getInstance () {
        if (is_null(self::$instance)) { self::$instance = new self(); }
        return self::$instance;
    }

    /**
     * @param null $hmm
     * @return Authentication
     */
    public static function user($hmm=null)
    {
//        if(is_array($hmm))
//        {
//            foreach ($hmm as $k => $v)
//            {
//                self::$param[$k] = $v;
//            }
//            return new Authentication(self::$param['username'], self::$param['password']);
//            Debug::showDump($param, 'param');
//        }

            return new Authentication($hmm);
    }

    /**
     *  invoke request username value on session
     * @return null
     */
    public static function getUsername()
    {
        if($_SESSION != null)
        {
            return $_SESSION['login']['username'];
        }
        return null;

    }

    /**
     * To invoke request session value
     * @return null
     */
    public static function role()
    {
//        if($d=null){
            if($_SESSION != null)
            {
                return $_SESSION['login']['role'];
            }
        return null;
//            else
//            {
//                return header('Location: index.php');
//            }
//        }else{
//            if($d==self::grant($grant))
//            {
//                Debug::showDump($d, 'test');
//            }
//            elseif($d=='Admin')
//            {
//                Debug::showDump($d, 'test2');
//            }
//        }
//        return false;
    }

    /**
     * Granting each role for each view
     * @param $grant
     * @return bool|void
     */
    public static function grant($grant)
    {
        if(is_array($grant))
        {

                if(!in_array(Auth::role(), $grant))
                {
                    return exit('Access Violation!');
                }
                else
                {
                    return true;
                }

        }
        if(Auth::role()==$grant){
            return true;
        }
        else{
            return exit('Access Violation!');
        }
    }

    /**
     * supposed to be included in grant only but i make an almost redundant
     * to GRANT VIEW on each link
     * @param $grant
     * @return bool|string
     */
    public static function grantlink($grant)
    {
        if(is_array($grant))
        {
           foreach ($grant as $u)
           {
               if(Auth::role() == $u)
               {
                   return true;
               }
           }
        }else{
            if(Auth::role()==$grant){
                return true;
            }
            else{
                return null;
            }
        }
        return false;
    }

    /**
     * LOGOUT Controller on facade.
     */
    public static function destroy()
    {

        setcookie('login','', 1);
        unset($_SESSION);
        session_destroy();
    }

}
