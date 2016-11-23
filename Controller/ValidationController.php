<?php

namespace Controller;


if (!defined('__ROOT__')) define('__ROOT__', dirname(dirname(__FILE__)));

use Controller\Helpers\Debug;
use Controller\Helpers\Methods;
use IValidation\ValidationInterface;
use Controller\DatabaseController as db;
include(__ROOT__.'/Controller/IValidation/ValidationInterface.php');
require_once(__ROOT__.'/middleware/declaration.php');


/**
 * Class Validation
 * To validate and push message
 * Validity::init($_POST)
 * @package Controller
 */
class Validation extends DbProto implements ValidationInterface
{

    public $username;
    public $password;
    public $gender;
    public $phone;
    public $address;
    public $bool = [];
    public $fieldname = [
        'username',
        'password',
        'gender',
        'phone',
        'address',
    ];
    public $userRules = array(
        'min' => '8',
        'max' => '20'
    );
    public $passRules = array(
        'min' => '6'
    );
    public $message;

    /**
     * To get validation result
     * @return array
     */
    public function getBool()
    {
        return (array)$this->bool;
    }

    /**
     *  Method to push validation result and triggerig action if all return true
     * @param array $bool
     */
    public function setBool($bool)
    {
        if(is_array($bool)){
            foreach ($bool as $k => $v)
            {
                $this->bool[$k] = $v;
            }
        }
    }


    /**
     * Wrapping every element with array @param in mind
     * Validation constructor.
     * @param null $data
     */
    public function __construct($data=null)
    {
        parent::__construct();
        $data = Methods::escape($data, DbProto::getInstance()->mysqli);


        if($data['password'] == $data['confirm_password']) {
            $this->validatePassword($data['password'], $data['confirm_password']);
            foreach ($data as $key => $val) {
                if ($key === 'username') {
                    //                $this->validateUsername($val);
                    $this->validateUsername($val);
                }
                if ($key === 'phone') {
                    $this->validatePhone($val);
                }
                if ($key === 'address') {
                    $this->validateAddress($val);
                }
                if ($key === 'email') {
                    $this->validateEmail($val);
                }
            }
        }
    }

    /**
     * Validating username to Database, if true will push boolean value to assigned prop
     * @param $input
     * @return mixed
     *
     */
    public function validateUsernameToDB($input)
    {

            parent::__construct();
        $input = Methods::escape($input, DbProto::getInstance()->mysqli);

        $sql = "SELECT username FROM users WHERE username='$input'";

            $row = $this->getInstance()->make()->query($sql)->fetch_array(MYSQLI_BOTH);

        if ($row) {
                $this->setBool(['username' => false]);
                return $this->bool['username'];
            }else{
                $this->setBool(['username' => true]);
            }
    }

    /**
     * @param $input
     * @return mixed
     */
    public function validatePasswordToDB($input)
    {
        parent::__construct();
        $input = Methods::escape($input, DbProto::getInstance()->mysqli);
        if ($v === 2) {
            $sql = "SELECT password FROM users WHERE username='{$input}'";
            $row = $this->fetchCheck($sql);

            if ($row) {
                $this->setBool(['password' => true]);
                return $this->bool['password'];
            }else{
                $this->setBool(['password' => false]);
                return $this->bool['password'];
            }
        }
    }

    /**
     * @param $input
     * @return mixed
     */
    public function validateUsername($input)
    {

        $v = 0;
        if (!ctype_alpha($input)) {
            $message['username'] = array('message' => 'Username is not alphabet');
            $this->setBool(['username' => false]);
        } else {
            $v += 1;
        }

        if (strlen($input) <= $this->userRules['min'] && strlen($input) >= $this->userRules['max'])
        {
            $message['username'] = array('message' => 'must between 8 and 20');
            $this->setBool(['username' => false]);
        }else{
        $v += 1;
    }

        if ($v === 2) {
            return $this->validateUsernameToDB($input);
        }

    }

    //Later use to pass with AJAX
    /**
     * Di
     */
    public function displayError()
    {
        $pass = $this->message;
        if(count($pass) > 0)
        {
            foreach($this->message as $key => $val)
            {
                foreach ($val as $v)
                {
                    echo $v;
                }
            }
        }
    }

    /**
     * Displaying pushed errors everytime logic is triggered
     */
    public function displayAlert()
    {
        if(isset($this->message)){
            $pass = $this->message;
            if(count($pass) > 0)
            {
                echo '<div class="alert alert-danger">';
                echo '<ul>';
                foreach($this->message as $key => $val)
                    {
                        foreach ($val as $v)
                        {
                            echo '<li>'.$v.'</li>';
                        }
                    }
                echo '</ul>';
                echo '<div>';
            }
        }
    }

    /**
     * @param $input
     * @param $comparable
     * @return bool
     */
    public function validatePassword($input, $comparable)
    {
        $v = 0;
        if (!ctype_alnum($input)) {
            $this->message['password'] = ['message' => '[Password] must contain alphabet and numeric'];
            echo $this->message['password']['message'];
        } else {
            $v += 1;
        }

        if (strlen($input) <= $this->passRules['min'])
        {
             $this->message['password'] = ['message' => '[Password] must more than 6 character'];
            echo  $this->message['password']['message'];
        }else{
        $v+=1; }

        if($input !== $comparable)
        {
             $this->message['password'] = ['message' => 'Confirmation [password] doesnt match'];
            echo  $this->message['password']['message'];
        }else{
            $v+=1;
        }


        if ($v == 3) {
                $this->setBool(['password' => true]);
            return true;
        }
        $this->setBool(['password' => false]);

    }

    /**
     * @param $input
     */
    public function validateEmail($input)
    {
        if(!filter_var($input,  FILTER_VALIDATE_EMAIL) === true){
             $this->message['email'] = ['message' => '[Email] invalid'];
        }else{
            $this->setBool(['email' => true]);
        }
    }

    /**
     * @param $input
     */
    public function validatePhone($input)
    {
        if(substr($input, 0, 2) != '08')
        {
             $this->message['phone'] = ['message' => '[Phone] Must be started with 08'];
        }else{
            $this->setBool(['phone'=> true]);
        }
    }

    /**
     * @param $input
     */
    public function validateAddress($input)
    {
        if(preg_match('/street/', strtolower($input)))
        {
            $this->setBool(['address'=> true]);
        }else{
             $this->message['address'] = ['message' => '[Address] must contain street'];

        }
    }

}

/**
 * Class Validity
 * @package Controller
 */
class Validity extends Validation
{
    /**
     * @param $data
     * @return bool
     */
    public static function check($data)
    {
        if(!isset($data)){
            return false;
        }
            $object = new Validation($data);
            foreach ($object->getBool() as $k => $v)
            {
//                Debug::showDump($object->getBool(), 'testtsateoasjtmkgprdsiuofglxnk');
                if($v == false)
                {
                    return false;
                }
            }
//        Debug::showDump($object->getBool(), 'testtsateoasjtmkgprdsiuofglxnk');
        return true;
    }
}

?>

<?php
//namespace Controller;
////
////use Controller\DatabaseController;
////use IValidation\ValidationInterface;
//
////require_once('/DatabaseController.php');
////require_once('IValidation/ValidationInterface.php');
//if (!defined('__ROOT__')) define('__ROOT__', dirname(dirname(__FILE__)));
//
//use Controller\Helpers\Debug;
//use IValidation\ValidationInterface;
//use Controller\DatabaseController as db;
//include(__ROOT__.'/Controller/IValidation/ValidationInterface.php');
//require_once(__ROOT__.'\middleware/declaration.php');
//
//
//class Validation extends db implements ValidationInterface
//{
//
//    public $username;
//    public $password;
//    public $gender;
//    public $phone;
//    public $address;
//    public $bool = [];
//    public $fieldname = [
//        'username',
//        'password',
//        'gender',
//        'phone',
//        'address',
//    ];
//    public $userRules = array(
//        'min' => '8',
//        'max' => '20'
//    );
//    public $passRules = array(
//        'min' => '6'
//    );
//    public $message;
//
//    /**
//     * @return array
//     */
//    public function getBool()
//    {
//        return (array)$this->bool;
//    }
//
//    /**
//     * @param array $bool
//     */
//    public function setBool($bool)
//    {
//        if(is_array($bool)){
//            foreach ($bool as $k => $v)
//            {
//                $this->bool[$k] = $v;
//
//            }
//        }
//    }
//
//
//
//    public function __construct($data=null)
//    {
//        parent::__construct();
//
//        if($data['password'] == $data['confirm_password']) {
//            $this->validatePassword($data['password'], $data['confirm_password']);
//            foreach ($data as $key => $val) {
//                if ($key === 'username') {
//                    //                $this->validateUsername($val);
//                    $this->validateUsername($val);
//                }
//                if ($key === 'phone') {
//                    $this->validatePhone($val);
//                }
//                if ($key === 'address') {
//                    $this->validateAddress($val);
//                }
//                if ($key === 'email') {
//                    $this->validateEmail($val);
//                }
//            }
//        }
////        if(is_array($val)){
////            $this->validatePassword($val, $key['confirm_password']);
////        }else{
////            $this->validatePassword($val, $data['confirm_password']);
////        }
//    }
//
//    public function validateUsernameToDB($input)
//    {
//
//            parent::__construct();
//            $sql = "SELECT username FROM users WHERE username='$input'";
//
//             $row = $this->fetchData($sql);
//
//        if ($row) {
//                $this->setBool(['username' => false]);
//                return $this->bool['username'];
//            }else{
//                $this->setBool(['username' => true]);
//            }
//    }
//
//    public function validatePasswordToDB($input)
//    {
//        parent::__construct();
//        if ($v === 2) {
//            $sql = "SELECT password FROM users WHERE username='{$input}'";
//            $row = $this->fetchCheck($sql);
//
//            if ($row) {
//                $this->setBool(['password' => true]);
//                return $this->bool['password'];
//            }else{
//                $this->setBool(['password' => false]);
//                return $this->bool['password'];
//            }
//        }
//    }
//
//    public function validateUsername($input)
//    {
//
//        $v = 0;
//        if (!ctype_alpha($input)) {
//            $message['username'] = array('message' => 'Username is not alphabet');
//            $this->setBool(['username' => false]);
//        } else {
//            $v += 1;
//        }
//
//        if (strlen($input) <= $this->userRules['min'] && strlen($input) >= $this->userRules['max'])
//        {
//            $message['username'] = array('message' => 'must between 8 and 20');
//            $this->setBool(['username' => false]);
//        }else{
//        $v += 1;
//    }
//
//        if ($v === 2) {
//            return $this->validateUsernameToDB($input);
//        }
//
//    }
//
//    //Later use to pass with AJAX
//    public function displayError()
//    {
//        $pass = $this->message;
//        if(count($pass) > 0)
//        {
//            foreach($this->message as $key => $val)
//            {
//                foreach ($val as $v)
//                {
//                    echo $v;
//                }
//            }
//        }
//    }
//
//    public function displayAlert()
//    {
//        $pass = $this->message;
//        if(count($pass) > 0)
//        {
//
//            echo '<div class="alert alert-danger">';
//            echo '<ul>';
//            foreach($this->message as $key => $val)
//                {
//                    foreach ($val as $v)
//                    {
//                        echo '<li>'.$v.'</li>';
//                    }
//                }
//            echo '</ul>';
//            echo '<div>';
//        }
//    }
//
//    public function validatePassword($input, $comparable)
//    {
//        $v = 0;
//        if (!ctype_alnum($input)) {
//            $this->message['password'] = ['message' => '[Password] must contain alphabet and numeric'];
//            echo $this->message['password']['message'];
//        } else {
//            $v += 1;
//        }
//
//        if (strlen($input) <= $this->passRules['min'])
//        {
//             $this->message['password'] = ['message' => '[Password] must more than 6 character'];
//            echo  $this->message['password']['message'];
//        }else{
//        $v+=1; }
//
//        if($input != $comparable)
//        {
//             $this->message['password'] = ['message' => 'Confirmation [password] doesnt match'];
//            echo  $this->message['password']['message'];
//        }else{
//            $v+=1;
//        }
//
//        if ($v === 3) {
//                $this->setBool(['password' => true]);
//        }
//    }
//
//    public function validateEmail($input)
//    {
//        if(!filter_var($input,  FILTER_VALIDATE_EMAIL) === true){
//             $this->message['email'] = ['message' => '[Email] invalid'];
//        }else{
//            $this->setBool(['email' => true]);
//        }
//    }
//
//    public function validatePhone($input)
//    {
//        if(substr($input, 0, 2) != '08')
//        {
//             $this->message['phone'] = ['message' => '[Phone] Must be started with 08'];
//        }else{
//            $this->setBool(['phone'=> true]);
//        }
//    }
//    public function validateAddress($input)
//    {
//        if(preg_match('/street/', strtolower($input)))
//        {
//            $this->setBool(['address'=> true]);
//        }else{
//             $this->message['address'] = ['message' => '[Address] must contain street'];
//
//        }
//    }
//
//}
//
//class Validity
//{
//    public static function check($data)
//    {
//            $a = new Validation($data);
//            foreach ($a->getBool() as $k => $v)
//            {
//                Debug::showDump($k, $v);
//                if($v == false)
//                {
//                    return false;
//                    Debug::showDump($data, 'testasta');
//                }
//            }
//        return true;
//    }
//}
//
//?>
