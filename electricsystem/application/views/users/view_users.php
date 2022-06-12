<?php include 'public_header.php'; ?>

<div class="content">
	<h1>All Category</h1>

	<div class="search-content">
		<?php echo form_open('UserController/searchCategory', ['class'=> 'search-category-form', 'role' => 'search']) ?>
		  <input type="text" placeholder="Search.." name="search_category" />
		  <button type="submit">Search</button>
		<?php echo form_close(); ?>

		<div class="search-error">
			<?= form_error('search_category', '<p class="search-error" >', '</p>'); ?>	
		</div>

	</div>

	<div>
		<!-- <?php if($errors = $this->session->flashdata('success_message')): ?>
			<div class="alert-message alert-message-success">
				<?= $errors; ?>
			</div>
		<?php endif; ?> -->

		<?php if($errors = $this->session->flashdata('failed_message')): ?>
			<div class="alert-message alert-message-danger">
				<?= $errors; ?>
			</div>
		<?php endif; ?>

	</div>


	<table class="articles-table">
		<thead>
			<tr>
				<th>Sr. No.</th>
				<th>Category Title</th>
				<th>Published On</th>
			</tr>
		</thead>
		<tbody>
			<!-- <?php echo "<pre>"; print_r($articles); ?> -->
			<?php if(count($articles)): ?>
			<?php $count = $this->uri->segment(3, 0); ?>
			<?php foreach($articles as $article): ?>
			<tr>
					<td><?= ++$count; ?></td>
					<td><?= anchor("UserController/categoryDetails/{$article->id}", $article->title); ?></td>
					<td><?= date('d M Y H:m:s', strtotime( $article->created_at )); ?></td>
			</tr>
				<?php endforeach; ?>
			<?php else: ?>
				<tr>
					<td colspan="3">No Records found..</td>
				</tr>
			<?php endif; ?>			
		</tbody>
	</table>
	
</div>

<div class="link-pagination">
	<?= $this->pagination->create_links(); ?>
</div>

<?php include 'public_footer.php'; ?>