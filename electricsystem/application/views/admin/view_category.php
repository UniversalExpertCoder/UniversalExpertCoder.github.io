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

	<?php if( count((array)$categories) ): ?>

		<?php $count = $this->uri->segment(3, 0); ?>
		
		<div class="grid-container">
			<?php for ($k=0; $k < count($categories); $k++) :

				$category = $categories[$k];
				include 'view_card.php';

			?>

			<?php endfor; ?>


		</div>

	<?php else: ?>
		<div class="alert-dashboard-category alert-dashboard-category-danger">
			<span style="display: flex;justify-content: center;">No Record Found!!</span>
		</div>
	<?php endif; ?>

</div>			

<div class="link-pagination">
	<?= $this->pagination->create_links(); ?>
</div>

<?php include "view_footer.php"; ?>