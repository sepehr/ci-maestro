<?php
/**
 * @file index.php
 * Welcome module default view.
 */
?>
<div class="content-inner well">
	<div class="page-header">
		<h1>
			Welcome to CodeIgniter Maestro
			<small>The Kickstart Kit !</small>
		</h1>

		<div class="profile pull-right well" style="position: relative; bottom: 40px; background: #f2f2f2; padding: 12px;">
		<?php if ($current_user): ?>
			<?php echo $current_user->picture ?>
			<?php echo anchor('auth', $current_user->email) ?>
		<?php else: ?>
			<?php echo anchor('auth/login', 'Login') ?>
		<?php endif; ?>
		</div>
	</div>

	<div class="content">
		<h3>Features</h3>

		<div class="container">
			<ul class="span5" style="margin-left: 30px">
				<li>Modular and HMVC ready.</li>
				<li>MongoDB integrated!</li>
				<li>Twitter bootstrap integrated!</li>
				<li>Hierarchical base controllers</li>
				<li>Base CRUD models with optional MongoDB support.</li>
				<li>Extended session library with optional MongoDB support.</li>
				<li>Role-based authentication with optional MongoDB support.</li>
			</ul>
			<ul class="span5">
				<li>REST API generation engine with optional MongoDB support.</li>
				<li>Easy unit testing framework.</li>
				<li>Support for parent/child themes, plus assets and templating helpers.</li>
				<li>Profiler and debug console in place.</li>
				<li>Support for triggering and registring application events on runtime.</li>
				<li>Asset combination, compression and caching.</li>
				<li>And many more features plus <em>no documentaion !</em></li>
			</ul>
		</div>

		<br /><br />
		<h3>Users demo</h3>
		<p>
			You might want to browse a simple demo of authentication and user operations <a href="<?php echo site_url('auth/login') ?>">here</a>.
			The username is <code>admin@admin.com</code> and the password: <code>password</code>
		</p>

		<br /><br />
		<h4>Dropping this page</h4>
		<p>
			The page you are looking at is being generated dynamically.
			If you would like to edit this page you'll find it located at:
			<code>application/modules/welcome/views/index.php</code>
			<br />
			The corresponding controller for this page is found at:
			<code>application/modules/welcome/controllers/welcome.php</code>
		</p>

	</div>
</div>