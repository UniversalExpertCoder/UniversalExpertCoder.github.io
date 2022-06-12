<?php include "view_header.php"; ?>

<div>
	<?php if($errors = $this->session->flashdata('dashboard_category_success')): ?>
		<div class="alert-dashboard-category alert-dashboard-category-success">
			<span style="display: flex;justify-content: center;"><?= $errors; ?></span>
		</div>
	<?php endif; ?>

	<?php if($errors = $this->session->flashdata('dashboard_category_failed')): ?>
		<div class="alert-dashboard-category alert-dashboard-category-danger">
			<span style="display: flex;justify-content: center;"><?= $errors; ?></span>
		</div>
	<?php endif; ?>

</div>			

<div class="parent-container">
	<div class="dashboard-container">
		<a class="dashboard-card" href="<?php echo base_url().'AdminController/profile'; ?>">
			<div class="dashboard-container-image">
				<img class="dashboard-image" src="<?php echo base_url().'uploads/default/default.png'; ?>" />
			</div>

			<div class="dashboard-container-name">
				<p class="dashboard-name">Users</p>
				<p class="dashboard-name"><?php echo $number_users; ?></p>
			</div>
		</a>

		<a class="dashboard-card" href="<?php echo base_url().'AdminController/category'; ?>">
			<div class="dashboard-container-image">
				<img class="dashboard-image" src="<?php echo base_url().'uploads/default/default.png'; ?>" />
				
			</div>
			<div class="dashboard-container-name">
				<p class="dashboard-name">Category</p>
				<p class="dashboard-name"><?php echo $number_category; ?></p>
			</div>
		</a>

		<a class="dashboard-card" href="<?php echo base_url().'AdminController/products'; ?>">
			<div class="dashboard-container-image">
				<img class="dashboard-image" src="<?php echo base_url().'uploads/default/default.png'; ?>" />
				
			</div>
			<div class="dashboard-container-name">
				<p class="dashboard-name">Products</p>
				<p class="dashboard-name"><?php echo $number_products; ?></p>
			</div>
		</a>

		<a class="dashboard-card" href="<?php echo base_url().'AdminController/notification'; ?>">
			<div class="dashboard-container-image">
				<img class="dashboard-image" src="<?php echo base_url().'uploads/default/default.png'; ?>" />
				
			</div>
			<div class="dashboard-container-name">
				<p class="dashboard-name">Notification</p>
				<p class="dashboard-name"><?php echo $number_products; ?></p>
			</div>
		</a>

	</div>

</div>			

<?php include "view_footer.php"; ?>