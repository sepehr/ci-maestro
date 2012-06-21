<div class="content-inner well">
    <div class="page-header">
        <h1>User Deactivation
            <small>Are you sure you want to deactivate the user <em><?php echo $user->username; ?></em> ?</small>
        </h1>
    </div>

    <?php echo form_open('auth/deactivate/' . $user->id);?>

      <p>
		<input type="radio" name="confirm" value="yes" checked="checked" />
        <label for="confirm" class="help-inline">Yes</label>

		<input type="radio" name="confirm" value="no" />
        <label for="confirm" class="help-inline">No</label>
      </p>

      <?php echo form_hidden($csrf); ?>
      <?php echo form_hidden(array('id'=>$user->id)); ?>

      <p><?php echo form_submit('submit', 'Submit', 'class="btn btn-primary"');?></p>

    <?php echo form_close();?>

</div>
