<div class="content-inner well">
    <div class="page-header">
        <h1>Create User <small>Please enter the user information below.</small></h1>
    </div>

    <?php echo form_open("auth/create_user");?>
      <p>First Name:<br />
      <?php echo form_input($first_name);?>
      </p>

      <p>Last Name:<br />
      <?php echo form_input($last_name);?>
      </p>

      <p>Company Name:<br />
      <?php echo form_input($company);?>
      </p>

      <p>Email:<br />
      <?php echo form_input($email);?>
      </p>

      <p>Phone:<br />
      <?php echo form_input($phone1);?>
      </p>

      <p>Password:<br />
      <?php echo form_input($password);?>
      </p>

      <p>Confirm Password:<br />
      <?php echo form_input($password_confirm);?>
      </p>


      <p><?php echo form_submit('submit', 'Create User', 'class="btn btn-primary"');?></p>


    <?php echo form_close();?>

</div>
