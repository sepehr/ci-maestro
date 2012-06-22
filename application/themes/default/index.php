<?php
/**
* @file index.php
* Default layout file.
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<!--
	<base href="<?php echo $base ?>"> -->
	<title><?php echo $title ?></title>

	<!-- Metas, viewports, etc. -->
	<?php echo $head ?>

	<!-- Stylesheets -->
	<?php echo Assets::css() ?>

	<!-- Javascripts -->
	<?php echo Assets::js() ?>
</head>

<body class="<?php echo $body_classes ?>">

	<div class="container">
		<div class="row">
			<div class="span12">

				<!-- Messages -->
				<div class="messages-wrapper">
					<?php echo Template::message() ?>
				</div>

				<div class="content">
					<!-- Header region -->
					<?php echo Template::block('block_header_region') ?>

					<!-- Content -->
					<?php echo Template::yield() ?>

					<!-- Footer region -->
					<?php echo Template::block('block_footer_region') ?>

					<!-- Profiler -->
					<div class="pull-right label">
						<i class="icon icon-time icon-white"></i>
						<strong>{elapsed_time}</strong> seconds
					</div>
				</div> <!-- /.content -->

			</div> <!-- /.span12 -->
		</div> <!-- /.row -->
	</div> <!-- /.container -->

</body>
</html>