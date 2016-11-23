<?php include_once('layouts/head.php') ?>
<?php use Controller\Auth; ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group pull-right">
            	<form action="index.php?views=home&Controller=auth" method="POST">

       				 <input type="hidden" value="login" name="views" hidden>
       				 <input type="hidden" value="auth" name="Controller" hidden>
            		<div class="form-group">
            		<label for="" class="form-label">Username</label>
            		<input placeholder="username" name="username" type="text" minlength="5" class="form-control" required>
            		</div>
            		<div class="form-group">
            		<label for="" class="form-label">Password</label>
            		<input placeholder="password" name="password" type="password" minlength="5" class="form-control" required>
            		</div>
            		<div class="form-group">
            		<label for="remember"><small>Remember Me ?</small></label>
					<input type="checkbox" name="remember" value="true" class="checkbox">
            		</div>
            		<div class="form-group">
            		<button class="btn btn-info">Submit</button>
            		<a href="index.php?views=login&Controller=forgot">Forgot password?</a>
            		</div>
            	</form>
            </div>
        </div>
    </div>
</div>

<?php ob_start();
include_once('layouts/foot.php') ?>
<?php ob_end_flush(); ?>
