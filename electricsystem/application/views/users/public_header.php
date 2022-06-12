<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
<title></title>
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/css/users_style.css">
	<?= link_tag('assets/css/category_details.css'); ?>
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

				<div class="header-button" style="display: none;">
					<!-- <a href="<?= base_url(); ?>AdminController/logout">Logout</a> -->
					<?php echo anchor('LoginController', 'Login', array('class' => 'login-button')); ?>
				</div>

			</div>
			<!--Header Ends Here-->
		</div>
		<!--Header Wrapper End Here-->
