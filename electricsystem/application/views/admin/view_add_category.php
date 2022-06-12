<?php include 'view_header.php'; ?>

<div class="parent-container">
	<?php echo form_open_multipart('AdminController/createCategory', ['class'=> 'add-category']); ?>

		<?php /*echo form_hidden('user_id', $this->session->userdata('user_id'));*/ ?>
		<?php /*echo form_hidden('created_at', date('Y-m-d H:i:s'));*/ ?>

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

		<h4 class="title"><strong>Category Image:</strong></h4>

		<div class="upload-button">

			<img id="output" src="<?php echo base_url(); ?>/uploads/default/default.png" />
			
			<input type="file" name="category_image" accept="image/*" onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])">

		</div>

		<span class="errors">
			<?php
			if ( isset( $upload_error ) ) {
				echo $upload_error;
			}
			?>
		</span>

		<h4 class="title"><strong>Category Name:</strong></h4>
		<?php echo form_input(['name' => 'category_name', 'placeholder' => 'Category Name', 'value' => set_value('category_name')]); ?>
		<span class="errors"><?php echo form_error('category_name'); ?></span>

		<h4 class="title"><strong>Category Description:</strong></h4>
		<?php 
			$data = array(
				'name'        => 'category_description',
				'id'          => 'category_description',
				'value'       => set_value('category_description'),
				'placeholder' => 'Category Description',
				'rows'        => '10',
				'cols'        => '10',
				'style'       => 'width:100%',
			);

			echo form_textarea($data); 

		?>
		<span class="errors"><?php echo form_error('category_description'); ?></span>
		
		<div>
			<?php echo form_submit(['name' => 'submit', 'value' => 'Submit', 'class' => 'admin-button']); ?>
			<?php echo form_reset(['name' => 'reset', 'value' => 'Reset', 'class' => 'admin-cancel-button']); ?>
		</div>

	</form>

</div>

<!-- <?php echo validation_errors(); ?> -->
<?php include 'view_footer.php'; ?>