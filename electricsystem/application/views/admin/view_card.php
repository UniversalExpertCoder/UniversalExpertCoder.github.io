<div class="card">

	<?php if( empty($category-> category_image) || strlen($category-> category_image) === 0 || $category-> category_image === 'default.png'): ?>
		<img class="card-view-image" style="width: 100px; height: 100px;" src="<?php echo base_url(); ?>/uploads/default/default.png" />
	<?php else: ?>
		<img class="card-view-image" style="width: 100px; height: 100px;" src="<?php echo base_url().'uploads/category/'.$category-> category_image; ?>" />
	<?php endif; ?>

	<p class="card-name"><div class="title-dot"><div><?php echo ++$count?></div></div><h4><b><?php echo $category-> category_name; ?></b></h4></p>
			
	<div class="grid-child-posts">Description : <?php echo $category-> category_description; ?></div>

	<ul class="social-icons">
		<li><a href="#"><i class="icon icon-building"></i></a></li>
		<li><a href="#"><i class="icon icon-shopping_bag"></i></a></li>
		<li><a href="#"><i class="icon icon-shopping_bag"></i></a></li>
		<li><a href="#"><i class="icon icon-shopping_bag"></i></a></li>
	</ul>

	<?php 

		if ($category-> category_status === "0") {
			/*echo "<a class='buttonActionView' style='margin: 10px;' href='activeCategory'>Active</a>";*/ 
			echo form_open('AdminController/activeCategory',array('class' => 'buttonFormView')),
			form_hidden('category_id', $category -> category_id),
			form_hidden('category_status', '1'),
			form_hidden('category_activity', 'Category has been actived successfully'),
			form_submit(['name' => 'submit', 'value' => 'Active', 'class' => 'buttonDeleteView']),
			form_close();

		} else {
			/*echo "<a class='buttonInactiveView' style='margin: 10px;' href='activeCategory'>Inactive</a>";*/
			echo form_open('AdminController/activeCategory',array('class' => 'buttonFormInactiveView')),
			form_hidden('category_id', $category -> category_id),
			form_hidden('category_status', '0'),
			form_hidden('category_activity', 'Category has been deactived successfully'),
			form_submit(['name' => 'submit', 'value' => 'Inactive', 'class' => 'buttonInactiveView']),
			form_close();
		} 

	?>

	<?= anchor("AdminController/editCategory/{$category-> category_id}", 'Edit', ['class' => 'buttonEditView', 'style' => 'display:none;']); ?>	

	<?php		
	
		echo form_open("AdminController/editCategory",array('class' => 'buttonFormView')),
		form_hidden('category_id', $category -> category_id),
		form_submit(['name' => 'submit', 'value' => 'Edit', 'class' => 'buttonDeleteView']),
		form_close();

	?>	

	<?=

		form_open('AdminController/deleteCategory',array('class' => 'buttonFormView')),
		form_hidden('category_id', $category -> category_id),
		form_hidden('category_name', $category -> category_name),
		form_submit(['name' => 'submit', 'value' => 'Delete', 'class' => 'buttonDeleteView']),
		form_close();

	?>

</div>