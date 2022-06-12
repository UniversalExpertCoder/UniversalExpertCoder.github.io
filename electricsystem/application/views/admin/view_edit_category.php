<?php include 'view_header.php'; ?>

<div class="parent-container">
	<?php echo form_open_multipart("AdminController/updateCategory", ['class'=> 'add-category']); ?>

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

			<?php if( empty($category-> category_image) ): ?>
				<img id="output" src="<?php echo base_url(); ?>/uploads/default/default.png" />
			<?php else: ?>
				<img id="output" src="<?php echo base_url().'uploads/category/'.$category-> category_image; ?>" />
			<?php endif; ?>
			
			<input type="file" name="category_image" accept="image/*" onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])" />

		</div>

		<span class="errors">
			<?php if ( isset( $upload_error ) ) {
				echo $upload_error;
			}
			?>
		</span>

		<h4 class="title"><strong>Category Title:</strong></h4>
		<?php echo form_input(['name' => 'category_name', 'placeholder' => 'Category Title', 'value' => set_value('category_name', $category -> category_name)]); ?>
		<span class="errors"><?php echo form_error('category_name'); ?></span>

		<h4 class="title"><strong>Category Body:</strong></h4>
		<?php echo form_textarea(['name' => 'category_description', 'placeholder' => 'Category Body', 'value' => set_value('category_description', $category -> category_description)]); ?>
		<span class="errors"><?php echo form_error('category_description'); ?></span>

		<div>
			<?php echo form_hidden('category_id', $category -> category_id); ?>
			<?php echo form_submit(['name' => 'submit', 'value' => 'Submit', 'class' => 'admin-button']); ?>
			<?php echo form_reset(['name' => 'reset', 'value' => 'Reset', 'class' => 'admin-cancel-button']); ?>
		</div>

	</form>

</div>

<!-- <?php echo validation_errors(); ?> -->
<?php include 'view_footer.php'; ?>