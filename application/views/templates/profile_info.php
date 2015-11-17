<div class="col-md-3 profile-img-wrapper">
		<img src="<?php echo asset_url('users/' . $photo); ?>">
		<div class="profile-img-overlay edit-item hidden"></div>
		<div class="profile-img-edit edit-item hidden">
					<span class="glyphicon glyphicon-camera hidden"></span>
					<input type="file" id="photo" name="photo" data-parsley-errors-container=".photo"/>
					<p class="photo field-error hidden"></p>
		</div>
</div>
<div class="col-md-6 profile-info-wrapper">
	<div class="profile-info-text hide-edit-profile">
		<h2><?php echo $fname . ' ' . $lname; ?></h2>
		<p><span class="glyphicon glyphicon-user"></span><?php echo $username; ?></p>
		<p class="flag-sibling"><span class="glyphicon glyphicon-map-marker"></span>From <?php echo $country_name; ?></p>
		<img class="country-flag" src="<?php echo asset_url('images/' . $country . '.png'); ?>">
		<p><span class="glyphicon glyphicon-calendar"></span>Joined in <?php echo $join_date; ?></p>
</div>
<div class="profile-info-contact hidden">
		<h3>Contact <?php echo $fname; ?></h3>
		<button class="button contact-btn"><span class="glyphicon glyphicon-calendar"></span></button>
		<button class="button contact-btn"><span class="glyphicon glyphicon-calendar"></span></button>
		<button class="button contact-btn"><span class="glyphicon glyphicon-calendar"></span></button>
		<button class="button contact-btn"><span class="glyphicon glyphicon-calendar"></span></button>
		<button class="button contact-btn"><span class="glyphicon glyphicon-calendar"></span></button>
</div>
