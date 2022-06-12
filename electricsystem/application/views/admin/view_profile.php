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
		<div class="cardProfileView">

			<?php if( empty($user_detail-> user_profile_image) ): ?>
				<img class="card-view-image" style="width: 100px; height: 100px;" src="<?php echo base_url(); ?>/uploads/default/default.png" />
			<?php else: ?>
				<img class="card-view-image" style="width: 100px; height: 100px;" src="<?php echo base_url().'uploads/category/'.$user_detail-> user_profile_image; ?>" />
			<?php endif; ?>
			 
			<p class="card-name"><h4><b><?php echo $user_detail-> username; ?></b></h4><div><?php echo $user_detail-> email; ?></div></p>
					
			<div class="buttonHorizontalView">

				<?php
				$operateColor = $user_detail-> user_status === "verified" ? array('class' => 'buttonProfileView') : array('class' => 'buttonActiveProfileView');
				$activity = $user_detail-> user_status === "verified" ? 'Inactive' : 'Active';
				$operate = $user_detail-> user_status === "verified" ? 'User has been deactivated successfully' : 'User has been activated successfully';
				
				echo form_open('AdminController/activityUser', $operateColor),
				form_hidden('user_id', $user_detail -> user_id),
				form_hidden('user_status', $user_detail-> user_status === "verified" ? 'unverified' : 'verified'),
				form_hidden('profile_activity', $operate),
				form_submit(['name' => 'submit', 'value' => $activity, 'class' => 'buttonTransparentView']),
				form_close();

			?>

			<div class="dividerView"></div>

			<?php		
			
				echo form_open("AdminController/editUserProfile",array('class' => 'buttonProfileView')),
				form_submit(['name' => 'submit', 'value' => 'Edit', 'class' => 'buttonTransparentView']),
				form_close();

			?>	

		</div>

		</div>

</div>			

<?php include "view_footer.php"; ?>