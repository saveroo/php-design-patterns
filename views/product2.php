<?php include('layouts/head.php') ?>

<?php

use Controller\Auth;
use Controller\Helpers\Debug;
use Controller\Helpers\Front;
use Controller\DbProto;
use Controller\Rendering;
use Controller\Render;

?>

<style>
    .glyphicon { margin-right:5px; }
    .thumbnail
    {
        margin-bottom: 20px;
        padding: 0px;
        -webkit-border-radius: 0px;
        -moz-border-radius: 0px;
        border-radius: 0px;
    }

    .item.list-group-item
    {
        float: none;
        width: 100%;
        background-color: #fff;
        margin-bottom: 10px;
    }
    .item.list-group-item:nth-of-type(odd):hover,.item.list-group-item:hover
    {
        background: #428bca;
    }

    .item.list-group-item .list-group-image
    {
        margin-right: 10px;
    }
    .item.list-group-item .thumbnail
    {
        margin-bottom: 0px;
    }
    .item.list-group-item .caption
    {
        padding: 9px 9px 0px 9px;
    }
    .item.list-group-item:nth-of-type(odd)
    {
        background: #eeeeee;
    }

    .item.list-group-item:before, .item.list-group-item:after
    {
        display: table;
        content: " ";
    }

    .item.list-group-item img
    {
        float: left;
    }
    .item.list-group-item:after
    {
        clear: both;
    }
    .list-group-item-text
    {
        margin: 0 0 11px;
    }

</style>
<div class="container">

    <?php

    $declare = new DbProto();
    $row = $declare->make()->query("SELECT * FROM users")->fetch_assoc();

    foreach ($row as $k => $v) {

        $x = new DbProto();
        $result = $x->make()->query("SELECT * FROM product");

        while ($obj = $result->fetch_object()) {
            //            echo $obj->ckName.'<br>';
            //            echo $obj->ckStock.'<br>';
            //            echo $obj->ckPrice.'<br>';
            //            echo $obj->ckImage.'<br>';
        }
        ?>


        <?php
    }


    ?>


    <div class="row">

        <div class="col-md-3">
            <p class="lead">Shop Name</p>
            <div class="list-group">
                <a href="#" class="list-group-item">Category 1</a>
                <a href="#" class="list-group-item">Category 2</a>
                <a href="#" class="list-group-item">Category 3</a>
            </div>
        </div>

        <div class="col-md-9">
            <div class="row">
                <form action="index.php?views=product&Controller=search&" method="GET">
                    <input type="hidden" name="views" value="product">
                    <input type="hidden" name="Controller" value="search">
                    <input type="text" name="search" placeholder="Find Cake"/>
                    <input type="submit" value="search"/>
                </form>
            </div>
            <div class="row carousel-holder">

<!--                <div class="col-md-12">-->
<!--                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">-->
<!--                        <ol class="carousel-indicators">-->
<!--                            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>-->
<!--                            <li data-target="#carousel-example-generic" data-slide-to="1"></li>-->
<!--                            <li data-target="#carousel-example-generic" data-slide-to="2"></li>-->
<!--                        </ol>-->
<!--                        <div class="carousel-inner">-->
<!--                            <div class="item active">-->
<!--                                <img class="slide-image" src="http://placehold.it/800x300" alt="">-->
<!--                            </div>-->
<!--                            <div class="item">-->
<!--                                <img class="slide-image" src="http://placehold.it/800x300" alt="">-->
<!--                            </div>-->
<!--                            <div class="item">-->
<!--                                <img class="slide-image" src="http://placehold.it/800x300" alt="">-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">-->
<!--                            <span class="glyphicon glyphicon-chevron-left"></span>-->
<!--                        </a>-->
<!--                        <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">-->
<!--                            <span class="glyphicon glyphicon-chevron-right"></span>-->
<!--                        </a>-->
<!--                    </div>-->
<!--                </div>-->

            </div>

            <div class="row">


                <?php
                $conditional = "";
                $perPage = 3;

                if (isset($_GET['page'])) {
                    $currentPage = $_GET['page'];
                } else {
                    $currentPage = 1;
                }

                if (isset($_GET['search'])) {
                    $search = $_GET['search'];
                    $conditional = " WHERE ProductName LIKE '%$search%'";
                }

                $set = ($currentPage - 1) * $perPage;

                $instance = new DbProto();
                $ins = $instance->getInstance();
                $sum = $ins->mysqli->query("SELECT COUNT(*) FROM product " . $conditional, MYSQLI_ASSOC);
                //Debug::showDump($sum);
                $amount = $sum->fetch_array();
                //Debug::showDump($amount);
                $offset = $instance->mysqli->query("SELECT * FROM product " . $conditional . " LIMIT $perPage OFFSET $set");

                //                    $proposeParent = $instance->mysqli->query("SELECT * FROM product");
                while ($feedback = $offset->fetch_object()) {

                    ?>
                    <div class="col-md-3">
                        <div class="thumbnail">
                            <img src="<?= $feedback->ckImage; ?>" alt="">
                            <div class="caption-full">
                                <h4 class="pull-right">IDR <?= $feedback->ckPrice; ?></h4>
                                <h4><a href="<?= $feedback->cake_id ?>"><?= $feedback->ckName; ?></a>
                                </h4>
                                <!--                                <p>Cake</p>-->
                            </div>
                            <div class="form-group">
                                <?php if (Auth::grantlink(['Admin'])) { ?>

                                    <a class="btn btn-danger"
                                       href="index.php?views=product&Controller=delete_product&product_id=<?= $feedback->cake_id ?>">Delete</a>

                                <?php } ?>
                                <?php if (Auth::grantlink(['Admin'])) { ?>
                                    <form
                                        action="index.php?views=edit&Controller=edit_product&product_id=<?= $feedback->cake_id ?>"
                                        method="POST">
                                        <input type="hidden" name="product_id" value="<?= $feedback->cake_id ?>">
                                        <button class="btn btn-warning">Edit</button>
                                        <!--                                    <a class="btn btn-warning"  href="index.php?views=edit&Controller=edit_product&product_id=-->
                                        <!--">Edit</a>-->
                                    </form>
                                <?php } ?>
                                <?php if (Auth::grantlink(['Admin', 'Member'])) { ?>

                                    <a class="btn btn-success pull-right" href="h">Add to cart</a>

                                <?php } ?>
                            </div>
                            <div class="ratings">

                                <p class="pull-right"><?= mt_rand(9, 890) ?> reviews</p>
                                <p>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star-empty"></span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix visible-xs-block"></div>
                <?php } ?>
                <div>
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
                </div>
                <?php
                //$a = new Rendering('product');
                //$a->Show('product');
                ?>

            </div>

        </div>

    </div>

</div>
<script>
    $(document).ready(function() {
        $('#list').click(function(event){event.preventDefault();$('#products .item').addClass('list-group-item');});
        $('#grid').click(function(event){event.preventDefault();$('#products .item').removeClass('list-group-item');$('#products .item').addClass('grid-group-item');});
    });
</script>

<?php include('layouts/foot.php') ?> 