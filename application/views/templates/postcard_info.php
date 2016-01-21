<div class="img-container col-md-7">
		<div class="img-wrapper">
				<div class="img-edit hidden"></div>
				<img class="img-responsive" src="<?php echo asset_url('postcards/' . $postcard['photo']); ?>" />
				<div class="edit-img edit-postcard hidden">
							<span class="glyphicon glyphicon-camera"></span>
						<input type="file" id="photo" name="photo" data-parsley-errors-container=".photo">
						<p class="field-error photo hidden"></p>
				</div>
		</div>
</div>
<!-- showing fields -->
<div class="postcard-text-container show-postcard col-md-5">
		<h2><?php echo $postcard['description'] ?></h2>
			<p><span class="glyphicon glyphicon-user"></span>By
				<?php if (is_null($postcard['owner'])) echo 'You'; else echo "<a href='" . site_url('profile/view/' . $postcard['owner']) . "'>" . $postcard['owner'] . "</a>";?></p>
		<p class="flag-sibling">
				<span class="glyphicon glyphicon-map-marker"></span>
				<?php if ($postcard['is_swap'] == 0) { echo 'Sent by ' . $postcard['sender']. ' - '; } ?>
		<?php echo $country_name; ?></p>
		<img class="country-flag" src="<?php echo asset_url('images/' . $postcard['country'] . '.png'); ?>">

		<?php if ($postcard['is_swap'] == 0): ?>
				<p><span class="glyphicon glyphicon-calendar"></span>Received on <?php echo $postcard['date_received'] ?></p>
				<p><?php echo $postcard['type'] . ' - '.  $postcard['state'] ?></p>

				<?php if ($postcard['postcrossing_id']): ?>
				<p>Postcrossing ID: <?php echo $postcard['postcrossing_id']; ?></p>
				<?php endif; ?>
		<?php else: ?>
				<p><span class="glyphicon glyphicon-send"></span>For swap <?php if ($postcard['is_available'] == 1) { echo '- Available'; }  else { echo '- Not available';}?></p>
		<?php endif; ?>
		<?php if ($postcard['favorite_count'] > 0): ?>
								<p><span class="glyphicon glyphicon-star"></span><?php echo $postcard['favorite_count']; ?></p>
		<?php endif; ?>


		<button class="btn-postcard button" data-href="<?php echo site_url('categories/'. $postcard['category_id']); ?>"><span class="glyphicon glyphicon-th-list"></span><?php echo $category; ?></button>


		<?php if (!empty($tags)): ?>
		<div class="row">
				<div class="col-md-12 tags-wrapper-postcard">
					<p><span class="glyphicon glyphicon-tags"></span> Tags</p>
					<?php foreach ($tags as $key => $tag): ?>
						<button class="btn-postcard button" data-href="<?php echo site_url('tags/' . $tag['tagname']); ?>"><?php echo $tag['tagname']; ?></button>
					<?php endforeach; ?>
		</div>
	</div>
	<?php endif; ?>
</div>
</div>
