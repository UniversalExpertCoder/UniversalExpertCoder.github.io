<?php include 'public_header.php'; ?>

<?php echo form_open('LoginController/changePassword', ['class'=> 'login-form']); ?>

	<?php if($errors = $this->session->flashdata('login_failed')): ?>
		<div class="alert-login alert-danger">
			<?= $errors; ?>
		</div>
	<?php endif; ?>

	<h4 class="title"><strong>Current Password:</strong></h4>
	<?php echo form_input(['name' => 'current_password', 'placeholder' => 'Current Password', 'value' => set_value('current_password')]); ?>
	<span class="errors"><?php echo form_error('current_password'); ?></span>

	<h4 class="title"><strong>New Password:</strong></h4>
	<?php echo form_password(['name' => 'new_password', 'placeholder' => 'New Password']); ?>
	<span class="errors"><?php echo form_error('new_password'); ?></span>

	<?php echo form_submit(['name' => 'submit', 'value' => 'Login', 'class' => 'login-button']); ?>

</form>

<?php include 'public_footer.php'; ?>