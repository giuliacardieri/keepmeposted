<div class="row">
	<div class="show-tags-wrapper col-md-12">
		<div class="row">
			<?php if (!empty($postcard)): ?>
				<?php foreach ($postcard as $tag): ?>
					<div class="tag-wrapper">
						<button class="btn-postcard button"><span class="glyphicon glyphicon-tag"></span><?php echo $tag['tagname']; ?></button>
					</div>
				<?php endforeach; ?>
		<?php else: ?>
			<p>No tags found.</p>
		<?php endif; ?>
		</div>
	</div>
</div>
