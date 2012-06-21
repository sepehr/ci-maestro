<div class="content-inner well">
    <div class="page-header">
        <h1>Forgot Password
            <small>Please enter your email address so we can send you an email to reset your password.</small>
        </h1>
    </div>

<?php echo form_open("auth/forgot_password");?>

      <p>Email Address:<br />
      <?php echo form_input($email);?>
      </p>

      <p><?php echo form_submit('submit', 'Submit', 'class="btn btn-primary"');?></p>

<?php echo form_close();?>
</div>