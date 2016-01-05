<div class="col-xs-4 col-xs-offset-4 col-sm-4 col-sm-offset-4 col-md-3 profile-img-wrapper">
		<img src="<?php echo asset_url('users/' . $photo); ?>">
		<div class="profile-img-overlay edit-item hidden"></div>
		<div class="profile-img-edit edit-item hidden">
			<span class="glyphicon glyphicon-camera hidden"></span>
			<input type="file" id="photo" name="photo" data-parsley-errors-container=".photo"/>
			<p class="photo field-error hidden"></p>
		</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-5 profile-info-wrapper">
	<div class="profile-info-text hide-edit-profile">
		<h2><?php echo $fname . ' ' . $lname; ?></h2>
		<p><span class="glyphicon glyphicon-user"></span><a href="<?php echo site_url('profile/'. $username) ?>"><?php echo $username; ?></a></p>
		<p class="flag-sibling"><span class="glyphicon glyphicon-map-marker"></span>From <?php echo $country_name; ?></p>
		<img class="country-flag" src="<?php echo asset_url('images/' . $country . '.png'); ?>">
		<p><span class="glyphicon glyphicon-calendar"></span>Joined in <?php echo $join_date; ?></p>
		<?php if (!is_null($facebook) && $show_facebook == 1): ?>
			<p><img class="icon" src="<?php echo asset_url('images/fb-icon.png'); ?>" alt="facebook icon" /><a href="http://facebook.com/<?php echo $facebook; ?>" target="blank"><?php echo $facebook; ?></a></p>
		<?php endif; ?>
		<?php if (!is_null($twitter) && $show_twitter == 1): ?>
			<p><img class="icon" src="<?php echo asset_url('images/tw-icon.png'); ?>" alt="twitter icon" /><a href="http://twitter.com/<?php echo $twitter; ?>" target="blank">@<?php echo $twitter; ?></a></p>
		<?php endif; ?>
		<?php if (!is_null($postcrossing) && $show_postcrossing == 1): ?>
			<p><img class="icon" src="<?php echo asset_url('images/postcrossing-icon.png'); ?>" alt="postcrossing icon" /><a href="http://postcrossing.com/user/<?php echo $postcrossing; ?>" target="blank"><?php echo $postcrossing; ?></a></p>
		<?php endif; ?>
		<?php if (!is_null($postcrossing_forum) && $show_forum == 1): ?>
			<p><img class="icon" src="<?php echo asset_url('images/forum-icon.png'); ?>" alt="postcrossing forum icon" /><a href="http://forum.postcrossing.com/member.php?action=viewpro&member=<?php echo $postcrossing_forum; ?>" target="blank"><?php echo $postcrossing_forum; ?></a></p>
		<?php endif; ?>                 
	</div>
</div>
