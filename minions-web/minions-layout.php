<!DOCTYPE html>
<html>
<head>
	<title><?=Minions::$arguments['title']; ?></title>
</head>
<body>
	<!-- Errors and Default messages -->
	<?php Minions::Content("messages"); ?>
	<!-- End Errors and Default Messages -->

	<!-- Page Content -->
	<?php Minions::Content("page"); ?>
	<!-- End Page Content -->
</body>
</html>