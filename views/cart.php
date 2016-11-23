<?php include('layouts/head.php') ?>

<?php
use Controller\Auth;
use Controller\DbProto;

?>



<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?=\Controller\Helpers\Front::pullMessage('Cart')?>
            <h2>Your Cart</h2>
            <div class="panel-group">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" href="#userlist">Detail</a>
                        </h4>
                    </div>
                    <div id="userlist" class="panel-collapse">
                        <div class="panel-body">
                            <table class="table table-bordered table-responsive table-stripped">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cake Name</th>
                                    <th>Sub Total</th>
                                    <th>Quantity</th>
                                    <th>Remove</th>

                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $instance = new DbProto();

                                $cid='';
                                $total = 0;
                                $tqty = 0;
                                if(isset($_SESSION['login']['cart'])){
                                    foreach ($_SESSION['login']['cart'] as $id=>$x)
                                    {
                                        $cid = $cid.$id.",";
                                    }

                                $cid = rtrim($cid, ',');
                                }
                                $q = "SELECT cake_id, ckImage, ckName, ckPrice FROM product where cake_id IN ($cid)";
                                $proposeParent = $instance->mysqli->query($q) or die('You have no item');
                                while ($put = $proposeParent->fetch_object())
                                {
                                    $sub = $put->ckPrice*$_SESSION['login']['cart'][$put->cake_id]['qty'];
                                    ?>
                                    <tr>

                                        <td><?=$put->cake_id?></td>
                                        <td><img src="<?=$put->ckImage?>" style="width: 25px;height: 25px" alt=""> <?=$put->ckName?></td>
                                        <td>IDR <?=$sub?></td>
                                        <td width="20%">
                                            <form action="index.php?views=cart&Controller=update_cart" method="POST">
                                                <input type="hidden" name="item_id" value="<?=$put->cake_id?>">
                                            <div class="input-group">
                                                <input min="1" name="qty" value="<?=$_SESSION['login']['cart'][$put->cake_id]['qty']?>" type="number" class="form-control">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default">Update</button>
                                                </span>
                                            </div>
                                            </form>
                                        </td>
                                        <td><a class="btn btn-danger" href="index.php?view=cart&Controller=remove_cart&item_id=<?=$put->cake_id?>">
                                                Remove
                                            </a></td>

                                    </tr>
                                    <?php
                                    $total += $sub;
                                    $tqty += $_SESSION['login']['cart'][$put->cake_id]['qty'];
                                }

                                ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="2">Total</td>
                                    <td>IDR <?=$total?></td>
                                    <td><?= $tqty?></td>
                                    <td><a href="index.php?views=cart&Controller=checkout" class="btn btn-success">Checkout</a></td>
                                </tr>
                                </tfoot>

                            </table>
                        </div>


                        <div class="panel-footer">Panel Footer</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php include('layouts/foot.php') ?>
