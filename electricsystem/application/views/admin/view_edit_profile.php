<?php include 'view_header.php'; ?>

<div class="parent-container">
	<?php echo form_open_multipart("AdminController/updateUserProfile", ['class'=> 'add-category']); ?>

		<?php if($errors = $this->session->flashdata('admin_category_success')): ?>
			<div class="alert-category alert-category-success">
				<?= $errors; ?>
			</div>
		<?php endif; ?>

		<?php if($errors = $this->session->flashdata('admin_category_failed')): ?>
			<div class="alert-category alert-category-danger">
				<?= $errors; ?>
			</div>
		<?php endif; ?>

		<h4 class="title"><strong>User Image:</strong></h4>
		
		<div class="upload-button">

			<?php if( empty($user_detail-> user_profile_image) ): ?>
				<img id="output" src="<?php echo base_url(); ?>/uploads/default/default.png" />
			<?php else: ?>
				<img id="output" src="<?php echo base_url().'uploads/category/'.$user_detail-> user_profile_image; ?>" />
			<?php endif; ?>
			
			<!-- <?php echo form_upload(['name' => 'profile_image']); ?> -->
			<!-- <input type="file" name="profile_image" accept="image/*" onchange="loadFile(event)"> -->
			<input type="file" name="profile_image" accept="image/*" onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])">

		</div>

		<span class="errors">
			<?php
			if ( isset( $upload_error ) ) {
				echo $upload_error;
			}
			?>
		</span>
			 
		<h4 class="title"><strong>Username:</strong></h4>
		<?php echo form_input(['name' => 'username', 'placeholder' => 'Username', 'value' => set_value('username', $user_detail -> username)]); ?>
		<span class="errors"><?php echo form_error('username'); ?></span>

		<div>
			<?php echo form_submit(['name' => 'submit', 'value' => 'Submit', 'class' => 'admin-button']); ?>
			<?php echo form_reset(['name' => 'reset', 'value' => 'Reset', 'class' => 'admin-cancel-button']); ?>
		</div>

	</form>

</div>

<script>
  var loadFile = function(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
      URL.revokeObjectURL(output.src)
    }
  };
</script>

<?php include 'view_footer.php'; ?>