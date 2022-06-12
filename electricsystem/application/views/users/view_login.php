<?php include 'public_header.php'; ?>

<!-- <form method="post" action="" id="login_form" class="login-form">
	<h4><strong>Email:</strong></h4>
	<input type="email" name="email" placeholder="Email" value="<?php if($_POST && isset($_POST['login'])) echo $_POST['email']; ?>" required="required" />
	<h4><strong>Password:</strong></h4>
	<input type="password" name="password" placeholder="Password" value="<?php if($_POST && isset($_POST['login'])) echo $_POST['password']; ?>" required="required" />
	<button name="login">Login</button>
	<button class="login-cancel-button" name="cancel">Cancel</button>
</form> -->

<?php echo form_open('LoginController/login', ['class'=> 'login-form']); ?>

<?php if($errors = $this->session->flashdata('login_failed')): ?>
	<div class="alert-login alert-danger">
		<?= $errors; ?>
	</div>
<?php endif; ?>

<h4 class="title"><strong>Email:</strong></h4>
<?php echo form_input(['name' => 'email', 'placeholder' => 'Email', 'value' => set_value('email')]); ?>
<span class="errors"><?php echo form_error('email'); ?></span>

<h4 class="title"><strong>Password:</strong></h4>
<?php echo form_password(['name' => 'password', 'placeholder' => 'Password']); ?>
<span class="errors"><?php echo form_error('password'); ?></span>

<?php echo form_submit(['name' => 'submit', 'value' => 'Login', 'class' => 'login-button']); ?>
<?php echo form_reset(['name' => 'reset', 'value' => 'Cancel', 'class' => 'login-cancel-button']); ?>

</form>

<div class="login-form">
	<?php echo anchor('LoginController/viewChangePassword', 'Change Password', array('class' => 'password-button')); ?>

</div>

<!-- <?php echo validation_errors(); ?> -->
<?php include 'public_footer.php'; ?>