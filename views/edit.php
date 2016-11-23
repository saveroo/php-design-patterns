<?php include('layouts/head.php') ?>

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
 * Date: 5/31/2016
 * Time: 9:10 PM
 */
use Controller\Auth;
use Controller\DbProto;
use Controller\Helpers\Debug;
use Controller\Helpers\Front;
if(isset($_REQUEST['Controller']) && $_REQUEST['Controller'] == 'edit_product') {
$_SESSION['product_id'] = $_REQUEST['product_id'];
    $cache = DbProto::getInstance()->make()->query("SELECT * FROM product WHERE cake_id='".$_SESSION['product_id']."'")->fetch_object();
//Debug::showDump($_SESSION);
    Front::pullMessage('Product');
    ?>
    test
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div id="product" >
                    <div class="panel-body">

                        <form action="index.php?views=product&Controller=edit_product" method="POST" enctype="multipart/form-data">
                            <input type="hidden" value="dashboard" name="views" hidden>
                            <input type="hidden" value="edit_product" name="Controller" hidden>
                            <input type="hidden" value="<?=$_SESSION['product_id']?>" name="product_id" hidden>

                            <div class="form-group">
                                <label for="ckName" class="form-label">Cake Name</label>
                                <input placeholder="Name" value="<?=$cache->ckName?>" name="ckName" type="text" minlength="1" class="form-control" required>
                            </div>

                            <!-- PASSWORD FORM -->
                            <div class="form-group">
                                <label for="ckPrice" class="form-label">Cake Price</label>
                                <input placeholder="Price" value="<?=$cache->ckPrice?>" name="ckPrice" type="text" minlength="1" class="form-control" required>
                            </div>
                            <!-- EMAIL FORM -->
                            <div class="form-group">
                                <label for="ckStock" class="form-label">Cake Stock</label>
                                <input placeholder="Stock" value="<?=$cache->ckStock?>" name="ckStock" type="text" minlength="1" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="ckImage" class="form-label">Cake Image</label>
                                <input placeholder="Image" name="ckImage" type="file" class="form-control" >
                            </div>
                            <div class="form-group">
                                <img width="20%" height="20%" src="<?=$cache->ckImage?>" alt="">
                            </div>

                            <!-- SUBMIT FORM -->
                            <div class="form-group">
                                <button class="btn btn-info">Submit</button>
                            </div>
                        </form>
                    </div>
                    <div class="panel-footer">Panel Footer</div>
                </div>

            </div>
        </div>
    </div>





    <?php
}elseif($_GET['edit_user']){


?>


    <div class="container">
        <div class="row">
            <div class="col-md-12"></div>
        </div>
    </div>

<?php
}
    ?>

<?php include('layouts/foot.php') ?>

