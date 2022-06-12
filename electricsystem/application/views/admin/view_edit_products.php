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

	<?php echo form_open_multipart('AdminController/editProduct', ['class'=> 'add-category']); ?>

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

		<h4 class="title"><strong>Product Image:</strong></h4>
		<div class="upload-image-button">
			<?php if( empty($products-> product_image) ): ?>
				<img id="output" src="<?php echo base_url(); ?>/uploads/default/default.png" />
			<?php else: ?>
				<img id="output" src="<?php echo base_url().'uploads/category/'.$products-> product_image; ?>" />
			<?php endif; ?>

			<div class="upload-image-button">
				<img id="output" src="<?php echo base_url(); ?>/assets/images/add.png" />
				<span>Choose Image</span>
				<input type="file" name="product_image" accept="image/*" onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])" />
			</div>
		</div>

		<span class="errors">
			<?php if ( isset( $upload_error ) ) {
				echo $upload_error;
			}
			?>
		</span>

		<h4 class="title"><strong>Product Name:</strong></h4>
		<?php echo form_input(['name' => 'product_name', 'placeholder' => 'Product Name', 'value' => set_value('product_name', $products -> product_name)]); ?>
		<span class="errors"><?php echo form_error('product_name'); ?></span>

		<h4 class="title"><strong>Product Description:</strong></h4>
		<?php 
			$data = array(
				'name'        => 'product_description',
				'value'       => set_value('product_description', $products -> product_description),
				'placeholder' => 'Product Description',
				'rows'        => '10',
				'cols'        => '10',
				'style'       => 'width:100%',
			);

			echo form_textarea($data); 

		?>
		<span class="errors"><?php echo form_error('product_description'); ?></span>

		<h4 class="title"><strong>Select Category Name:</strong></h4>
	
		<select class="select-category" name="category_id">
			<?php foreach ($categories as $key => $value) { ?>
				<option value="<?= $value->category_id ?>" <?php if ($value-> category_id === $products-> category_id) {
					echo "selected";
				} ?>>
					<?= $value->category_name ?>
				</option>
				
			<?php } ?>
		</select>
		<span class="errors"><?php echo form_error('category_name'); ?></span>

		<div class="product-activity">
			<label for="product_activity">Product Activity : </label> 

			<?php $product_status = $products -> product_status == 1 ? "checked" : ""; ?>

			<input type="checkbox" id="product_activity" name="product_activity" onclick="productActivity()" value="<?= $products -> product_status ?>" <?= $product_status ?>>
			<input type="hidden" id="product_activity_checked" name="product_activity_name" style="display:none;" value="<?= $products -> product_status ?>">
		</div>	

		<div>
			<?php echo form_hidden('product_id', $products -> product_id); ?>

			<?php echo form_submit(['name' => 'submit', 'value' => 'Submit', 'class' => 'admin-button']); ?>
			<?php echo form_reset(['name' => 'reset', 'value' => 'Reset', 'class' => 'admin-cancel-button']); ?>
		</div>

	</form>

</div>		

<script type="text/javascript">

function productActivity() {
  var checkBox = document.getElementById("product_activity");
  if (checkBox.checked == true){

    document.getElementById("product_activity_checked").style.display = "flex";
          document.getElementById('product_activity').value = 1;
        document.getElementById("product_activity_checked").value = "1";

  } else {

     document.getElementById("product_activity_checked").style.display = "none";
           document.getElementById('product_activity').value = 0;
        document.getElementById("product_activity_checked").value = "0";

  }
}
</script>		

<?php include "view_footer.php"; ?>