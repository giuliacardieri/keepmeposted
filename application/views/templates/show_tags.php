<div class="row">
	<div class="show-tags-wrapper col-md-12">
		<div class="row">
			<?php if (!empty($postcard)): ?>
				<?php foreach ($postcard as $tag): ?>
					<div class="tag-wrapper">
						<button class="btn-postcard button" data-href="<?php echo site_url('tags/index/' . $tag['tagname']); ?>"><span class="glyphicon glyphicon-tag"></span><?php echo $tag['tagname']; ?></button>
					</div>
				<?php endforeach; ?>
		<?php else: ?>
			<div class="col-md-12">
				<p>No tags found.</p>
			</div>
		<?php endif; ?>
		</div>
	</div>
</div>
