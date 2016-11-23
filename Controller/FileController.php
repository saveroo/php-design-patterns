<?php

namespace Controller;

use Controller\Helpers\Methods;
use Controller\Helpers\Debug;
use Controller\DbProto;

/**
 * Class FileController
 *
 * FileController::upload
 * Product::add
 * Product::search
 * Product::edit
 * Product::delete
 * PARAM are supposedly global for easy calling like $_POST
 * @package Controller
 */
class FileController{

    public $status;

    protected static $instance;
    protected $file;

    protected $location;
    protected $rules = ['jpeg', 'jpg', 'png'];

    //key of $_FILES
    protected $name;
    protected $type;
    protected $tmp_name;
    protected $error;
    protected $size;

    /**
     * FileController constructor.
     * @param $file
     * @param string $location
     */
    public function __construct($file, $location='')
    {
//        Debug::showDump($file, 'eawitgstg');
        if(is_array($file))
        {
            foreach ($_FILES['ckImage'] as $k => $v)
            {
                $this->{$k} = $v;
            }
        }


        $this->setLocation($location);

        if(!is_dir($this->getLocation()))
        {
            Debug::exception('Invalid directory');
        }

        foreach ($this->rules as $extension)
        {

            if(in_array($extension,$this->rules))
            {
                $this->upload();
//                Debug::showDump($this->upload(), 'tesat');
                break;
            }else{
                Debug::exception('Extension not allowed');
                break;
            }
        }
    }

    /**
     * Debug object
     */
//    public function __destruct()
//    {
//        print "FILE CONTROLLER DESTRUCTED";
//    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }


    /**
     *
     */
    protected function upload()
    {
        if($this->name != null)
        {
//            Debug::showDump($this->getLocation(), 'UPLOAD');
            $this->setLocation('assets/'.$this->name);
            if(move_uploaded_file($this->tmp_name,$this->getLocation())){
                $this->status = true;

            }
        }
    }

}

/**
 * Class ProductController
 *
 *
 * @package Controller
 */
class ProductController{

    protected static $singleton;
    public  $rules = ['ckName', 'ckPrice','ckStock'];
    public  $message;
    public  $bool = [];
    public  $saz;

    /**
     * @return array
     */
    public function getBool()
    {
        return (array)$this->bool;
    }

    /**
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
     * @return ProductController
     */
    public function init()
    {
        if(self::$singleton === null)
        {
            self::$singleton = new self();
        }
        return self::$singleton;
    }

    /**
     * ProductController constructor.
     */
    public function __construct()
    {

    }

    /**
     * @param $data
     * @param null $rules
     * @return bool
     */
    public function sanitize(&$data, $rules=null)
    {
        if(is_array($data)){
            foreach ($data as $d => $v)
            {
                foreach ($this->rules as $rule)
                {
                    if($d == $rule)
                    {
                        $new[$rule] = htmlspecialchars($v);
                        if(count($new) == 3)
                        {
                            break;
                        }
                    }
                }
            }
        }
        if(count($new) == count($this->rules))
        {
            $this->saz = $new;
            return $new;

        }
        return false;
    }

    /**
     *
     */
    public function __destruct()
    {
        print 'FILE CONTROLLER DESTRUCTED';
    }

    /**
     *  Validation for product
     * @param $data
     * @param null $message
     * @return bool
     */
    public function validation($data, $message=null)
    {
        if(is_null($data['ckName'])){
            $message['ckName'] = 'cKName must be filled';
            $this->pushMessage('ckName', 'cKName must be filled');

        }
        if(strlen($data['ckName']) < 1){
            $message['ckName'] = 'cKName must be more than 1 word';
            $this->pushMessage('ckName', 'cKName must be more than 1 word');

        }
        #######
        if(!is_numeric($data['ckPrice'])){
            $message['ckPrice'] = 'Price must contain only number';
            $this->pushMessage('ckPrice', 'Price must contain only number');

        }
        if(strlen($data['ckPrice']) === 0){
            $message['ckPrice'] = 'Price must be greater than zero';
            $this->pushMessage('ckPrice', 'Price must be greater than zero');

        }
        ######--========-
        if(!is_numeric($data['ckStock'])){
            $message['ckStock'] = 'Stock must contain only number';
            $this->pushMessage('ckStock', 'Stock must contain only number');

        }
        if(strlen($data['ckStock']) === 0){
            $message['ckStock'] = 'Stock must be greater than zero';
            $this->pushMessage('ckStock', 'Stock must be greater than zero');
        }
//        foreach ($this->setBool as $bol => $ku)
//        {
//            if($ku===false)
//            {
//                $this->setBool[$bol] == false;
//            }
//        }
        $a = array_values($this->getBool());
//        Debug::showDump($a);
        $im = implode(' ', $a);
        if(preg_match('/false/', $im))
        {
            return false;
        }else{
            return true;
        }

//        if(is_array($data) && count($data) == count($rules)){
//           foreach ($data as $dk => $vk)
//           {
//               foreach ($this->rules as $rk)
//               {
//                   $newData[$rk] = $vk;
//                   $this->pushMessage([$rk => '']);
//               }
//           }
//        }else
//        {
//            Debug::exception('Data is not array!');
//        }
//        if(count($new) == count($rules))
//        {
//            return true;
//        }
//        return false;
    }

    /**
     * @param array $collection
     * @param null $value
     * @param bool $autoassign
     * @return bool
     */
    protected function pushMessage($collection=[''], $value=null, $autoassign=true)
    {
        if(is_array($collection) && !is_null($value)){
            foreach($collection as $k => $v)
            {
                $this->message = [$k => $v];
            }
        }else{
            $this->message[$collection] = $value;
            if($autoassign == true)
            {
                $this->setBool([$collection => false]);
            }
        }
        return true;
    }
}

/**
 * Class Product
 * @package Controller
 */
class Product
{
    /**
     * @param $data
     * @param $file
     * @return bool
     */
    public static function add(&$data, $file)
    {
        $product = new ProductController();

        $ref = $product->sanitize($data);
//        Debug::showDump($data, 'saitize');

        if($product->sanitize($data)) //Sanitize to remove hidden inputform in $_POST for easier in the future
        {

//            Debug::showDump($product->saz, 'saitize');

            if($product->validation($product->saz)) //Validate after Pass by reference
            {

                foreach ($product->saz as $ada => $nya) //imploding into key.
                {
                    $col[$ada] = "'".$ada."'";
                    $fld[] =  "'".$nya."'";
                }
                $files = new FileController($file, "assets/");
                $q = "INSERT INTO product (`ckName`, `ckPrice`, `ckStock`, `ckImage`)
                      VALUES (".implode(',', $fld).",'".$files->getLocation()."')";
//                Debug::showDump($q);
                $ex = DbProto::getInstance()->make()->query($q);
                if($ex)
                {
                    return true;
                }
//                $files = new FileController($file, "assets/");
//                $implode = implode(',', $data);
//                $s = "INSERT INTO product (`ckName`, `ckPrice`, `ckStock`, `ckImage`)
//                          VALUES ('')";
//                Debug::showDump($s, 'QUERY');
                $files->__destruct();

            }
        }

    }
}

?>
