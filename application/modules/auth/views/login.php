<?php
/**
 * @file index.php
 * Auth module login view.
 */
?>
<div class="content-inner well">

	<div class="page-header">
		<h1>Members Login <small>Please login with your email and password below.</small></h1>
	</div>

    <?php echo form_open("auth/login");?>

      <p>
      	<label for="identity">Email/Username:</label>
      	<?php echo form_input($identity);?>
      </p>

      <p>
      	<label for="password">Password:</label>
      	<?php echo form_input($password);?>
      </p>

      <p>
	      <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
	      <label for="remember" class="help-inline">Remember me!</label>
	  </p>


      <p><?php echo form_submit('submit', 'Login', 'class="btn btn-primary"');?></p>


    <?php echo form_close();?>

    <p><a href="forgot_password">Forgot your password?</a></p>

</div>
