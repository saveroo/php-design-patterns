<?php
/**
 * Created by PhpStorm.
 * User: savero
 * Date: 5/31/2016
 * Time: 5:48 PM
 */
namespace Controller;

use Controller\DbProto;
use Controller\Helpers\Debug;
use Controller\Auth;

define('perPage', 10);

/**
 * Class Rendering
 * Not ready yet, in assumption we call this class like this statically
 * Render::product($limitpage)
 * Render::search();
 * Render::review();
 * @package Controller
 */
class Rendering
{
    private $pageNum = null;
    private $result = null;
    private $db = null;
    private $counter = 0;

    /**
     *
     */
    public function propose()
    {
        $this->db = new DbProto();
        $instance = $this->db->make();
        $bake = $make->query("SELECT * FROM " . $table);

    }

    /**
     * @param $table
     */
    public function Show($table)
    {


        $this->db = DbProto::getInstance();
        $instance = $this->db->make();
        $bake = $instance->query("SELECT * FROM product");
        Debug::showDump($bake);
        while ($put = $bake->fetch_object())
        echo " <div class=\"col-sm-4 col-lg-4 col-md-4\">\n";
        echo "                        <div class=\"thumbnail\">\n";
        echo "                            <img src=".$put->ckImage." alt=\"\">\n";
        echo "                            <div class=\"caption\">\n";
        echo "                                <h4 class=\"pull-right\">IDR $put->ckPrice</h4>\n";
        echo "                                <h4><a href=\"index.php?views=product&Controller=$put->cake_id\">$put->ckName</a>\n";
        echo "                                </h4>\n";
        echo "                                <p>Cake</p>\n";
        echo "                            </div>\n";
        echo "                            <div class=\"form-group\">\n";
        echo "                                <a class=\"btn btn-primary form-control\" target=\"_blank\" href=\"h\">Buy</a>\n";
        echo "                            </div>\n";
        echo "                            <div class=\"ratings\">\n";
        echo "\n";
        echo "                                <p class=\"pull-right\">18 reviews</p>\n";
        echo "                                <p>\n";
        echo "                                    <span class=\"glyphicon glyphicon-star\"></span>\n";
        echo "                                    <span class=\"glyphicon glyphicon-star\"></span>\n";
        echo "                                    <span class=\"glyphicon glyphicon-star\"></span>\n";
        echo "                                    <span class=\"glyphicon glyphicon-star\"></span>\n";
        echo "                                    <span class=\"glyphicon glyphicon-star-empty\"></span>\n";
        echo "                                </p>\n";
        echo "                            </div>\n";
        echo "                        </div>\n";
        echo "                    </div>\n";

    }

    /**
     * Rendering constructor.
     * @param $table
     */
    public function __construct($table)
    {
        $this->Show($table);
    }

    /**
     *
     */
    public function __destruct()
    {
        Print "Destroying Rendering Object";
    }

}

/**
 * Class Render
 * @package Controller
 */
class Render
{

    /**
     * @param $table
     * @return Rendering
     */
    public static function product($table)
    {
        return new Rendering($table);
    }
}

?>