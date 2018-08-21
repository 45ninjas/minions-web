<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, inital-scale=1.0">
	<title><?=Minions::$arguments['title']; ?></title>
	<link rel="stylesheet" type="text/css" href="<?=Minions::Asset("/css/styles.css")?>">
</head>
<body>
	<!-- Errors and Default messages -->
	<?php Minions::Content("messages"); ?>
	<!-- End Errors and Default Messages -->
	<main class="container box">

		<!-- Page Content -->
		<?php Minions::Content("page"); ?>
		<!-- End Page Content -->

		<?php Minions::Content("modals"); ?>
	</main>
</body>
</html>