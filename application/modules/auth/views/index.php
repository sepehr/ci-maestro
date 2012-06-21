<div class='content-inner well'>

	<div class="page-header">
		<h1>Users <small>Below is a list of the users.</small></h1>
	</div>

	<table class="table table-striped">
		<thead>
			<tr>
				<th>ID</th>
				<th>Username</th>
				<th>Email</th>
				<th>Groups</th>
				<th>Joined on</th>
				<th>Password</th>
				<th>Operations</th>
			</tr>
		<thead>

		<?php foreach ($users as $user):?>
			<tr>
				<td>
					<?php e($user->id) ?>
				</td>

				<td>
					<?php e($user->username) ?>
				</td>

				<td>
					<?php e($user->email) ?>
				</td>

				<td>
					<?php foreach ($user->groups as $group): ?>
						<?php e($group->name) ?><br />
	                <?php endforeach; ?>
				</td>

				<td>
					<?php e(date('D, F j', $user->created_on)) ?>
				</td>

				<td>
					<?php echo anchor('auth/change_password', 'Change', 'class="btn"') ?>
				</td>

				<td>
					<?php echo $user->active
						? anchor('auth/deactivate/' . $user->id, 'Deactivate', 'class="btn"')
						: anchor('auth/activate/'   . $user->id, 'Activate', 'class="btn"');
					?>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>

	<a class="btn btn-primary" href="<?php echo site_url('auth/create_user');?>">Create user</a>
</div>
