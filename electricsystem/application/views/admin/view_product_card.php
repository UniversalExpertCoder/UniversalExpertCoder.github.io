<div class="card">

	<?php if( empty($product-> product_image) || strlen($product-> product_image) === 0 || $product-> product_image === 'default.png'): ?>
		<img class="card-view-image" style="width: 100px; height: 100px;" src="<?php echo base_url(); ?>/uploads/default/default.png" />
	<?php else: ?>
		<img class="card-view-image" style="width: 100px; height: 100px;" src="<?php echo base_url().'uploads/category/'.$product-> product_image; ?>" />
	<?php endif; ?>

	<p class="card-name">
		<div class="title-dot">
			<div><?php echo ++$count?></div>
		</div>

		<div class="grid-child-posts"><?php echo substr($product-> product_name, 0, 10); ?></div>
		<div class="grid-child-posts">Description : <?php echo $product-> product_description; ?></div>
		<div class="grid-child-posts">Category : <?php echo $category-> category_name; ?></div>

	</p>
			
	<?php
		$operateColor = $product-> product_status === "0" ? array('class' => 'buttonFormView') : array('class' => 'buttonActiveProductView');
		$activity = $product-> product_status === "0" ? 'Inactive' : 'Active';
		$operate = $product-> product_status === "0" ? 'Product has been deactivated successfully' : 'Product has been activated successfully';

		echo form_open('AdminController/activeProduct', $operateColor),
		form_hidden('product_id', $product -> product_id),
		form_hidden('product_name', $product -> product_name),
		form_hidden('product_status', $product-> product_status === "0" ? '1' : '0'),
		form_hidden('profile_activity', $operate),
		form_submit(['name' => 'submit', 'value' => $activity, 'class' => 'buttonProductView']),
		form_close();
	?>

	<?php		
	
		echo form_open("AdminController/editProductView",array('class' => 'buttonFormView')),
		form_hidden('product_id', $product -> product_id),
		form_submit(['name' => 'submit', 'value' => 'Edit', 'class' => 'buttonProductView']),
		form_close();

	?>	

	<?=

		form_open('AdminController/deleteProduct',array('class' => 'buttonFormView')),
		form_hidden('product_id', $product -> product_id),
		form_hidden('product_name', $product -> product_name),
		form_submit(['name' => 'submit', 'value' => 'Delete', 'class' => 'buttonProductView']),
		form_close();

	?>

</div>