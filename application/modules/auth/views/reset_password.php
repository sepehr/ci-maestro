<div class="content-inner well">
    <div class="page-header">
        <h1>Change Password</h1>
    </div>

<?php echo form_open('auth/reset_password/' . $code);?>

      <p>New Password (at least <?php echo $min_password_length;?> characters long):<br />
      <?php echo form_input($new_password);?>
      </p>

      <p>Confirm New Password:<br />
      <?php echo form_input($new_password_confirm);?>
      </p>

      <?php echo form_input($user_id);?>
      <?php echo form_hidden($csrf); ?>
      <p><?php echo form_submit('submit', 'Change', 'class="btn btn-primary"');?></p>

<?php echo form_close();?>
