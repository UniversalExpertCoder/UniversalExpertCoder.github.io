<?php include 'public_header.php'; ?>

<div class="content">
	<div class="category-date"><?= date('d M Y H:m:s', strtotime( $articles->created_at )); ?></div>
	<div class="category-header">
		<div class="category-title">
		<div class="category-image">
			<?php if( !is_null($articles->image_path)): ?>
				<img src="<?= $articles->image_path?>" width="50px" height="50px">
				<?php endif; ?>
		</div>
			<?= $articles -> title ?>
		</div>
	</div>
	<div class="category-line"></div>
	<div class="category-body"><?= $articles -> body ?></div>
</div>
    
<?php include 'public_footer.php'; ?>
