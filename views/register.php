<?php if(isset($_SESSION['login']))header('Location:index.php'); ?>
<?php include('layouts/head.php') ?>

<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="form-group panel-default">
            	<form action="index.php?views=register&Controller=register" method="POST">
       				 <input type="hidden" value="register" name="views" hidden>
       				 <input type="hidden" value="register" name="Controller" hidden>

                    <div class="form-group">
            		<label for="" class="form-label">Username</label>
            		<input placeholder="username" name="username" type="text" minlength="5" class="form-control" required>
            		</div>

                    <!-- PASSWORD FORM -->
            		<div class="form-group">
            		<label for="" class="form-label">Password</label>
            		<input placeholder="password" name="password" type="password" minlength="5" class="form-control" required>
                    <label for="" class="form-label">Confirm Password</label>
                    <input placeholder="password" name="confirm_password" type="password" minlength="5" class="form-control" required>
            		</div>
                    <!-- EMAIL FORM -->
            		<div class="form-group">
                    <label for="" class="form-label">Email</label>
                    <input placeholder="Email" name="email" type="text" minlength="5" class="form-control" required>
                    </div>

                    <!-- GENDER FORM -->
                    <div class="form-group">
                    <label for="" class="form-label">Gender</label>
                    <select class="form-control" name="gender" id="">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                    </div>

                    <!-- PHONE FORM -->
                    <div class="form-group">
                    <label for="" class="form-label">Phone</label>
                    <input placeholder="number" name="phone" type="number" minlength="5" class="form-control" required>
                    </div>

                    <!-- ADDRESS FORM -->
                    <div class="form-group">
                    <label for="" class="form-label">Address</label>
                    <textarea class="form-control" name="address" id="" cols="30" rows="10"></textarea>
                    </div>

                    <!-- SUBMIT FORM -->
            		<div class="form-group">
            		<button class="btn btn-info">Submit</button>
            		</div>
            	</form>
            </div>
        </div>
    </div>
</div>


<?php include('layouts/foot.php') ?> 