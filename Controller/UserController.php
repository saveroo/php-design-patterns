<?php
namespace Controller;
/**
 * Created by PhpStorm.
 * User: savero
 * Date: 5/11/2016
 * Time: 3:33 AM
 */

use Controller\Authentication;
use Controller\Helpers\Debug;
use Controller\Helpers\Front;
use Controller\Validation;

/**
 * Class UserController
 * Basically later use will be like this
 * User::createUser([@param];
 * @package Controller
 */
class UserController extends DbProto
{
    public $username;
    public $password;
    public $rules = ['username', 'password', 'email', 'phone' ,'gender', 'address'];

    /**
     * @param $data
     * @param null $rules
     * @return mixed
     */
    public function filterField($data, $rules=null)
    {
        foreach ($data as $key => $val)
        {
            foreach ($rules as $a)
            {
                if($a == $key)
                {
                    $filtered[$a] = $val;
                }
            }
        }
        
        return $filtered;
        
    }

    /**
     * @param $input
     * @param null $action
     * @return bool
     */
    public function register($input, $action=null)
    {

        if(Validity::check($input) == true)
        {
            $input['password'] = md5($input['password']);
            foreach($this->filterField($input, $this->rules) as $k => $v)
            {

                $col[] =  "`".$k."`";
                if($k == 'phone')
                {
                    $field[] = $v;

                }else{
                    $field[] = "'".$v."'";
                }
            }

            $query = "INSERT INTO users (`usertype`,".implode(',', $col).") VALUES ('Member',".implode(',',$field).")";
//            Debug::showDump($query, 'new QUERY');
            $row = $this->getInstance()->make()->query($query);

            if($row)
            {
                if(!isset($action))
                {
                    Debug::showDump('', 'Successful');
                    return true;
                }
            }else{
                Debug::showDump('', 'User already there');
            }
        }
        return false;



    }

    /**
     * UserController constructor.
     * @param null $data
     */
    public function __construct($data = null)
    {

        $a = new Validation($data);
        $a->displayAlert();
//        Debug::showDump($a->getBool(), 'USER COSTRUEce');
    }

}

/**
 * Class User
 *
 * Facade class for userController
 * User::createUser
 *
 * @package Controller
 */
class User
{
    /**
     * @param $data
     */
    public static function CreateUser($data)
    {
        $a = new UserController($data);
        $a->register($data);
    }
}
?>







<?php //SPAGHETI AGAIN SO I REVAMP NEW ONE
//namespace Controller;
///**
// * Created by PhpStorm.
// * User: savero
// * Date: 5/11/2016
// * Time: 3:33 AM
// */
//
//use Controller\Authentication;
//use Controller\Helpers\Debug;
//use Controller\Helpers\Front;
//use Controller\Validation;
//
//class UserController extends DatabaseController
//{
//    public $username;
//    public $password;
//    public $userRole;
//    public $userPrivilege;
//    public $loginObject;
//
//
//    public function hasLoggedIn()
//    {
//        if(parent::getStatus() === true){
//            return true;
//        }
//    }
//
//    public function Authenticate()
//    {
//        if(parent::__construct($u, $p)){
////            return
//        }
//    }
//
//    /**
//     * @return mixed
//     */
//    public function getUserRole()
//    {
//        return $this->userRole;
//    }
//
//    /**
//     * @param mixed $userRole
//     */
//    public function setUserRole($userRole)
//    {
//        $this->userRole = $userRole;
//    }
//    /**
//     * @return mixed
//     */
//
//    public function getLoginObject()
//    {
//        return $this->loginObject;
//    }
//    /**
//     * @param mixed $loginObject
//     */
//    public function setLoginObject($loginObject)
//    {
//        $this->loginObject = $loginObject;
//    }
//
//    public function filterField($data, $rules=null)
//    {
//        $rules = ['username', 'password', 'email', 'phone' ,'gender', 'address'];
//        foreach ($data as $key => $val)
//        {
//            foreach ($rules as $a)
//            {
//                if($a == $key)
//                {
//                    $filtered[$a] = $val;
//                }
//            }
//        }
//        return $filtered;
//    }
//
//    public function register($input)
//    {
//
//
//
//        foreach($this->filterField($input) as $k => $v)
//        {
//                $col[] =  "`".$k."`";
//                if($k == 'phone')
//                {
//                    $field[] = $v;
//                }else{
//                    $field[] = "'".$v."'";
//                }
//
//        }
//        if(Validity::check($input) == true)
//        {
//            $query = "INSERT INTO users (`usertype`,".implode(',', $col).") VALUES ('Member',".implode(',',$field).")";
//            $row = $this->insert($query);
//
//            if($row)
//            {
//                Debug::showDump('', 'Successful');
//                return true;
//            }else{
//                Debug::showDump('', 'User already there');
//            }
//        }
//        return false;
//
//
//
//    }
//
//    public function __construct($data = null)
//    {
//
//        //        echo Debug::showDump($data);
////        parent::__construct($data);
//        $a = new Validation($data);
//        Debug::showDump($a->getBool(), 'USER COSTRUEce');
//    }
//
//}
//
//class User
//{
//    public static function CreateUser($data)
//    {
//        $a = new UserController($data);
//        $a->register($data);
//    }
//}