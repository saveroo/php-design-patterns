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
 * Date: 6/7/2016
 * Time: 1:43 PM
 */
 include('layouts/head.php');


use Controller\Auth;
use Controller\Helpers\Debug;
use Controller\Helpers\Front;
use Controller\DbProto;
use Controller\Rendering;
use Controller\Render;

?>
<style type="text/css">
    .btn-product{
        width: 100%;
    }
</style>
<br>

<hr>
<div class="container">
    <div class="row">
        <div class="col-md-11">
            <form class="form-inline pull-right" action="index.php?views=product&Controller=search&" method="GET">
               <div class="form-group">
                   <input type="hidden" name="views" value="product" >
                   <input type="hidden" name="Controller" value="search" >
                <input type="text" name="search" placeholder="Find Cake" class="form-control" />
               </div>
                <button class="btn btn-success">Find</button>
            </form>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
        <?php
        Front::pullMessage('Cart');
        Front::pullMessage('Product');


        $conditional = "";
        $perPage = 3;

        if (isset($_GET['page'])) {
            $currentPage = $_GET['page'];
        } else {
            $currentPage = 1;
        }

        if (isset($_GET['search'])) {
            $search = $_GET['search'];
            $conditional = "WHERE ckName LIKE '%".$search."%'";
        }

        $set = ($currentPage - 1) * $perPage;

        $instance = new DbProto();
        $ins = $instance->mysqli;
        $sum = $ins->query("SELECT COUNT(*) FROM product " . $conditional) or die("error:".$ins->error);
        $amount = $sum->fetch_row();
        $offset = $instance->mysqli->query("SELECT * FROM product " . $conditional . " LIMIT $perPage OFFSET $set");

        while($put = $offset->fetch_object()){ ?>
            <div class="col-sm-6 col-md-4">
                <div class="thumbnail" >
                    <h4 class="text-center"><span class="label label-info"><?=$put->ckName?></span></h4>
                    <img style="width: 250px;height: 200px" src="<?=$put->ckImage?>">
                    <div class="caption">
                        <div class="row">
                            <div class="col-md-6 col-xs-6">
                                <h3><?=$put->ckName?></h3>
                            </div>
                            <div class="col-md-6 col-xs-6 price">
                                <h3>
                                    <label>IDR <?=$put->ckPrice?></label></h3>
                            </div>
                        </div>
                        <p>Available Stock: <?=$put->ckStock?></p>
                        <div class="row">
                            <div class="col-md-4">
                                <a class="btn btn-primary btn-product"><span class="glyphicon glyphicon-thumbs-up"></span> Review</a>
                            </div>

                            <?php if(Auth::role() === 'Admin') { ?>
                            <div class="col-md-2">
                                <a class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
                            </div>
                            <div class="col-md-2">
                                <a href="index.php?views=edit&Controller=edit_product&product_id=<?=$put->cake_id?>" class="btn btn-info"><span class="glyphicon glyphicon-edit"></span></a>
                            </div>
                            <?php } ?>

                            <?php if(Auth::role(['Member', 'Admin'])){ ?>
                            <div class="col-md-4">
                                <a href="index.php?views=product&Controller=addtocart&cake_id=<?=$put->cake_id?>" class="btn btn-success btn-product"><span class="glyphicon glyphicon-shopping-cart"></span> Buy</a></div>
                            <?php }else{ echo "<div class='col-md-4'><a class='btn btn-success btn-product' href='index.php?views=register'><span class=\"glyphicon glyphicon-shopping-cart\"></span> Buy</a></div>";} ?>

                            </div>
                        <p> </p>
                    </div>
                </div>
            </div>
            <div class="clearfix visible-xs-block"></div>

            <?php } ?>

<!--            Pagination-->
                <ul class="pagination">

                    <li>
                        <?php
                        if ($currentPage > 1) {
                            $prev = $currentPage - 1;
                            echo "<a class='btn' href='index.php?views=product&page=$prev'>Prev</a>";
                        }
                        ?>
                    </li>
                    <li>
                        <?php
                        for ($i = 1; $i < ceil($amount[0] / $perPage); $i++) {
                            echo "<a class='btn' href='index.php?views=product&page=$i'>$i</a>";
                        }
                        ?>
                    </li >
                    <li >
                        <?php
                        if ($currentPage < ceil($amount[0] / $perPage)) {
                            $next = $currentPage + 1;
                            echo "<a class='btn' href='index.php?views=product&page=$next'>Next</a>";
                        }
                        ?>

                    </li>
                </ul>
<!--            Pagination End-->
        </div>

    </div>
</div>

<?php include('layouts/foot.php');?>
