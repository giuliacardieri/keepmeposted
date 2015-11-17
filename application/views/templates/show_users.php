<div class="row">
	<div class="show-users-wrapper col-md-12">
		<div class="row">
			<?php if (!empty($postcard)): ?>
				<?php foreach ($postcard as $user): ?>
					<div class="user-item col-md-4" data-href="<?php echo site_url('profile/view/' . $user['username']); ?>">
							<div class="row">
								<div class="user-img-wrapper col-md-4">
	                <img src="<?php echo asset_url('users/' . $user['photo']); ?>" alt="user photo">
								</div>
								<div class="user-info-wrapper col-md-8">
									<h2><?php echo $user['fname'] . ' ' . $user['lname']; ?></h2>
									<p><span class="glyphicon glyphicon-user"></span><?php echo $user['username']; ?></p>
									<p class="flag-sibling"><span class="glyphicon glyphicon-map-marker"></span><?php echo $user['country_name']; ?></p>
		              <img class="country-flag" src="<?php echo asset_url('images/' . $user['country'] . '.png'); ?>">
								</div>
							</div>
					</div>
				<?php endforeach; ?>
		<?php else: ?>
			<p>No users found.</p>
		<?php endif; ?>
		</div>
	</div>
</div>