<?php

namespace Controller;

use Controller\Helpers\Debug;
use mysqli;

/**
 * Class DbProto
 * child or facade is not yet created
 * supposed be like this
 * DbProto::rawQuery
 * DbProto::search to be used in rendering class.
 * DbProto::insert
 * @package Controller
 */
class DbProto
{
    const DB_USER = 'root';
    const DB_PASS = '123qwe';
    const DB_CONN = 'localhost';
    const DB_NAME = 'cakeshop';

    public static $singleton; //Singleton object to keep single instance recalling.
    public $data = array();

    public $mysqli; //parent class

    /**
     * DbProto constructor.
     */
    public function __construct()
    {
        try {
            $this->mysqli = new mysqli(self::DB_CONN, self::DB_USER, self::DB_PASS, self::DB_NAME);
        }catch (\Exception $E){
            Debug::exception($E);
        }
        $this->checkConnection();
    }

    /**
     * Debug Purpose
     */
    public function __destruct()
    {
     //   print "Destroy DB object";    //Debug Purpose
    }


    /**
     * Emptied so doesnt clone parent
     */
    private function __clone(){}

    /**
     * @return DbProto
     */
    public static function getInstance() {
        if(self::$singleton == null)
        {
            self::$singleton = new self();
        }
        return self::$singleton;
    }

    /**
     * Raising error if happens
     */
    public function checkConnection()
    {
        if (mysqli_connect_errno()) {
            printf("Connection failed: %s\n", mysqli_connect_error());
            exit();
        }
    }

    /**
     * @return mysqli
     */
    public function make()
    {
        return $this->mysqli;
    }

}


?>
