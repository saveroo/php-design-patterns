<?php include('layouts/head.php') ?>

<?php
use Controller\Auth;
use Controller\DbProto;

?>



<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Product Add</h2>
            <div class="panel-group">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" href="#product">Collapsible panel</a>
                        </h4>
                    </div>
                    <div id="product" class="panel-collapse collapse">
                        <div class="panel-body">
                            <form action="index.php?views=dashboard&Controller=addproduct" method="POST" enctype="multipart/form-data">
                                <input type="hidden" value="dashboard" name="views" hidden>
                                <input type="hidden" value="addproduct" name="Controller" hidden>

                                <div class="form-group">
                                    <label for="ckName" class="form-label">Cake Name</label>
                                    <input placeholder="Name" name="ckName" type="text" minlength="1" class="form-control" required>
                                </div>

                                <!-- PASSWORD FORM -->
                                <div class="form-group">
                                    <label for="ckPrice" class="form-label">Cake Price</label>
                                    <input placeholder="Price" name="ckPrice" type="text" minlength="1" class="form-control" required>
                                </div>
                                <!-- EMAIL FORM -->
                                <div class="form-group">
                                    <label for="ckStock" class="form-label">Cake Stock</label>
                                    <input placeholder="Stock" name="ckStock" type="text" minlength="1" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="ckImage" class="form-label">Cake Image</label>
                                    <input placeholder="Image" name="ckImage" type="file" class="form-control" >
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

            <h2>User List</h2>
            <div class="panel-group">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" href="#userlist">Collapsible panel</a>
                        </h4>
                    </div>
                    <div id="userlist" class="panel-collapse collapse">
                            <div class="panel-body">
                                <table class="table table-bordered table-stripped">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>usertype</th>
                                        <th>username</th>
                                        <th>email</th>
                                        <th>gender</th>
                                        <th>action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $instance = new DbProto();
                                    $proposeParent = $instance->mysqli->query("SELECT * FROM users");
                                    while ($put = $proposeParent->fetch_object())
                                    {
                                    ?>
                                    <tr>

                                        <td><?=$put->user_id?></td>
                                        <td><?=$put->usertype?></td>
                                        <td><?=$put->username?></td>
                                        <td><?=$put->email?></td>
                                        <td><?=$put->gender?></td>
                                        <td><a class="btn btn-danger" href="index.php?view=home&Controller=delete_user&user_id=<?=$put->user_id?>">
                                                Delete
                                            </a></td>

                                    </tr>
                                        <?php
                                    }

                                    ?>
                                    </tbody>

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
