<?php 

header("Cache-Control: no-cache");
header("Pragma: no-cache");
?>

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/css/dashboard.css">

	<style type="text/css">
		
		@font-face {
		    font-family: 'elegant_icon';
		    src: url('<?= base_url(); ?>assets/fonts/icomoon.ttf') format('truetype');
		}
		
	</style>

</head>
<body>
	<!--Container Start Here -->
	<div class="container">
		<div class="top-navigation-bar">
			<a href="#home" class="active">Logo</a>
				<div id="slide_menu_bar">
					<a href="#news">News</a>
					<a href="#contact">Contact</a>
					<a href="#about">About</a>
				</div>
			<a href="javascript:void(0);" class="icon-navigation-bar" onclick="slide_menu()">
				<i class="icon icon-home"></i>
			</a>
		</div>


		<div id="navigation_menu" class="overlay">
			<div class="navigation-background">
				<a href="<?= base_url(); ?>AdminController/profile" style="width: 100%;">
					<div class="navigation-header">
						<img src="<?= base_url(); ?>assets/images/elegant.png" class="navigation-logo" />
						<span class="navigation-text">Elegant</span>
					</div>
				</a>
				<div class="navigation-close"><a href="javascript:void(0)" onclick="slide_navigation_menu()"><i class="icon icon-cancel"></i></a></div>
			</div>
			<div class="overlay-content">
				<a href="<?= base_url(); ?>AdminController/dashboard"><i class="icon icon-dashboard1"></i><span class="navigation-text">Dashboard</span></a>
				<a href="<?= base_url(); ?>AdminController/category"><i class="icon icon-shopping_bag"></i><span class="navigation-text">Category</span></a>
				<a href="<?= base_url(); ?>AdminController/products"><i class="icon icon-location-shopping"></i><span class="navigation-text">Products</span></a>
				<a href="<?= base_url(); ?>AdminController/notification"><i class="icon icon-notification"></i><span class="navigation-text">Notification</span></a>
				
				<div>
					<a href="<?= base_url(); ?>AdminController/logout" class="navigation-logout"><i class="icon icon-exit"></i><span class="navigation-text">Logout</span></a>
				</div>
			</div>
		</div>

		<!--Header Wrapper Start Here-->
		<div class="header-wrapper">
			<!--Header Start Header-->
			<div class="header">
				
				<img src="<?= base_url(); ?>assets/images/elegant.gif" class="header-image" onclick="slide_navigation_menu()" />
				<h4 class="header-title">Elegant Knight Fire</h4>
				<div class="">
					<!-- <a href="<?= base_url(); ?>AdminController/logout">Logout</a> -->
					<?php echo anchor('AdminController/logout', 'Logout', array('class' => 'logout-button')); ?>
					<?php echo anchor('AdminController/addCategory', 'Add Category', array('class' => 'button-add-category')); ?>
				</div>
			</div>
			<!--Header Ends Here-->
		</div>
		<!--Header Wrapper End Here-->