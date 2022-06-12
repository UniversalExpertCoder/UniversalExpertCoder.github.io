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
	<div>

		<?php echo anchor('AdminController/addProducts', 'Add Product', array('class' => 'buttonProduct')); ?>
		
		<?php if( count((array)$products) ): ?>

			<?php $count = $this->uri->segment(3, 0); ?>
			
			<div class="grid-container">
				<?php for ($k=0; $k < count($products); $k++) :
					$product = $products[$k];

					$category = $this->db->select()->where('category_id', $product-> category_id)->from($this->table_category)->get()->row();

					include 'view_product_card.php';
				?>

				<?php endfor; ?>
			</div>

		<?php else: ?>
			<div class="alert-dashboard-category alert-dashboard-category-danger">
				<span style="display: flex;justify-content: center;">No Record Found!!</span>
			</div>
		<?php endif; ?>


	</div>

</div>			

<div class="link-pagination">
</div>

<?php include "view_footer.php"; ?>