<div class="row">
	<div class="show-users-wrapper col-md-12">
		<div class="row">
			<?php if (!empty($postcard)): ?>
				<?php foreach ($postcard as $key => $user): ?>
					<?php if ($key % 3 == 0 || $key == 0 ): ?>
						<div class="row">
					<?php endif; ?>
					<div class="col-md-4">
						<div class="user-item" data-href="<?php echo site_url('profile/' . $user['username']); ?>">
								<div class="row">
									<div class="user-img-wrapper col-xs-4 col-sm-4 col-md-6 col-lg-5">
		                				<img src="<?php echo asset_url('users/' . $user['photo']); ?>" alt="user photo">
									</div>
									<div class="user-info-wrapper col-xs-8 col-sm-8 col-md-6 col-lg-7">
										<h2><?php echo $user['fname'] . ' ' . $user['lname']; ?></h2>
										<p><span class="glyphicon glyphicon-user"></span><?php echo $user['username']; ?></p>
										<p class="flag-sibling"><span class="glyphicon glyphicon-map-marker"></span><?php echo $user['country_name']; ?></p>
			              				<img class="country-flag" src="<?php echo asset_url('images/' . $user['country'] . '.png'); ?>">
									</div>
								</div>
						</div>
					</div>
					<?php if (($key+1) % 3 == 0 || ($key+1) == sizeof($postcard) ): ?>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>
		<?php else: ?>
			<div class="col-md-12">
				<p>No users found.</p>
			</div>
		<?php endif; ?>
		</div>
	</div>
</div>
