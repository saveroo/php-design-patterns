<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>My Modern Cake</title>

    <!-- Bootstrap Core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
<!--    <link href="assets/css/shop-homepage.css" rel="stylesheet">-->


</head>
<?php
include(__ROOT__.'/middleware/declaration.php');

use Controller\Helpers\Debug;
use Controller\Helpers\Front;
use Controller\Auth;
//include('..\middleware\declaration.php');
?>
<body>
  <br />
  <br />
  <br />
  <br />
  <br />
<!--START DEBUG BAR-->
<!--START DEBUG BAR-->
<!--START DEBUG BAR-->
<!--START DEBUG BAR-->
<!--START DEBUG BAR-->
<!--START DEBUG BAR-->
<!--START DEBUG BAR-->
<!--START DEBUG BAR-->
<!--START DEBUG BAR-->
<!--START DEBUG BAR-->
<!--START DEBUG BAR-->
<!--START DEBUG BAR-->
<!--START DEBUG BAR-->
<!--START DEBUG BAR-->
<?php $debug = Debug::showDump($_SESSION, 'DEBUGBAR')?>
<?php Debug::showDump($_COOKIE, 'COOKIEBAR');?>
<!--END DEBUG BAR-->
<!--END DEBUG BAR-->
<!--END DEBUG BAR-->
<!--END DEBUG BAR-->
<!--END DEBUG BAR-->
<!--END DEBUG BAR-->
<!--END DEBUG BAR-->
<!--END DEBUG BAR-->
<!--END DEBUG BAR-->
<!--END DEBUG BAR-->
<!--END DEBUG BAR-->
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <!-- LEFT NAV -->
                <ul class="nav navbar-nav">
                    <li>
                        <a href="index.php?views=home">Home</a>
                    </li>
                      <li>
                      <?php if(Auth::grantlink(['Admin','Member', ''])){ ?>
                        <a href="index.php?views=product">Product</a>
                    <?php } ?>
                    </li>
                    <li>
                        <?php if(Auth::grantlink('Admin')){ ?>
                            <a href="index.php?views=dashboard">Dashboard</a>
                        <?php }else{} ?>
                    </li>
                <!-- END LEFT NAV -->
                </ul>
                <ul class="nav navbar-nav pull-right">
                <!-- START RIGHT NAV -->

                    <?php if(Auth::grantlink(['Member', 'Admin'])){ ?>
                    <li>
                        <a href="index.php?views=cart"><span class="badge"><?=Front::countCart();?></span><i class="glyphicon glyphicon-shopping-cart"></i></a>
                    </li>
                        <li>
                        <?php Front::showWelcome(); ?><a href="index.php?views=profile">Welcome, <?= '['.Auth::role().'] '.Auth::getUsername();?></a>
                    </li>
                    <?php } ?>

                    <?php if(Auth::role()==false){ ?>
                        <li>
                        <a href="index.php?views=login">Login</a>
                    </li>
                    <?php } ?>

                    <?php if(Auth::grantlink(['Member', 'Admin'])){ ?>
                    <li>
                        <a href="index.php?views=home&Controller=logout">Logout</a>
                    </li>
                    <?php } ?>



                    <?php if(Auth::grantlink('')){ ?>
                      <li>
                        <a href="index.php?views=register">Register</a>
                    </li>
                     <?php  } ?>
                </ul>
                <!-- END LEFT NAV -->
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
<br><br>
<hr>
    <!-- Page Content -->

    <!-- /.container -->
