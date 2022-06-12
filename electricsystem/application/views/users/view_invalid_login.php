<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/css/invalid_login.css">

</head>
<body>
	<!--Container Start Here -->
	<div class="container">
		<!--Header Wrapper Start Here-->
		<div class="header-wrapper">
			<!--Header Start Header-->
			<div class="header">
				<img src="<?= base_url(); ?>assets/images/elegant.png" class="header-image">
				<h4 class="header-title">Elegant Knight Fire</h4>
			</div>
			<!--Header Ends Here-->
		</div>
		<!--Header Wrapper End Here-->

		<div class="heading">
			<h2>Something Wrong...</h2>
		</div>
		<div class="login-form">
			<a href="<?= base_url(); ?>LoginController">Back</a>
		</div>

	</div>

</body>
</html>