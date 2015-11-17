    <div class="row">
        <div class="col-md-12 profile-wrapper">
          <form id="form-profile" class="profile-info-text" method="post" action="<?php echo site_url('profile/update_profile'); ?>" data-parsley-validate>
            <div class="profile-load">
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
                      <p><span class="glyphicon glyphicon-user"></span><a href="<?php echo site_url('profile/'. $username) ?>"><?php echo $username; ?></a></p>
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
              </div>
            </div>
              <!-- editable fields -->
            <div class="col-md-6 profile-edit-wrapper edit-item hidden">
                  <div class="row">
                      <div class="edit-field col-md-5">
                          <input type="text" id="fname" name="fname" data-parsley-required="true" data-parsley-length="[2, 25]" data-parsley-errors-container=".fname" value="<?php echo $fname; ?>">
                          <p class="fname field-error hidden"></p>
                      </div>
                      <div class="edit-field col-md-6">
                          <input type="text" id="lname" name="lname" data-parsley-required="true" data-parsley-length="[1, 50]" data-parsley-errors-container=".lname" value="<?php echo $lname; ?>">
                          <p class="lname field-error hidden"></p>
                      </div>
                  </div>
                  <div class="row">
                    <p class="edit-field col-md-6"><span class="glyphicon glyphicon-user"></span><?php echo $username; ?></p>
                  </div>
                  <div class="row">
                      <p class="edit-field col-md-2"><span class="glyphicon glyphicon-map-marker"></span></span>From </p>
                      <div class="edit-field col-md-4">
                            <select id="country" name="country" data-parsley-errors-container=".country" data-parsley-required="true">
                                <?php foreach ($countries as $country_ele ): ?>
                                <option value="<?php echo $country_ele['id'] ?>" <?php if ($country_ele['id'] == $country) { echo 'selected';} ?>>
                                    <?php echo $country_ele['name']; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                          <p class="country field-error hidden"></p>
                      </div>
                  </div>
                  <div class="row">
                    <p class="edit-field col-md-6"><span class="glyphicon glyphicon-calendar"></span>Joined in <?php echo $join_date; ?></p>
                  </div>
              </form>
              <div class="profile-info-contact hidden">
                  <h3>Contact</h3>
                  <?php if ($twitter): ?>
                  <div class="contact-group">
                    <input type="checkbox" name="twitter" id="twitter"/>
                    <label for="twitter"><span class="glyphicon glyphicon-user"></span>Show Twitter</label>
                  </div>
                  <?php endif; ?>
                  <?php if ($facebook): ?>
                  <div class="contact-group">
                    <input type="checkbox" name="facebook" id="facebook"/>
                    <label for="facebook"><span class="glyphicon glyphicon-user"></span>Show Facebook</label>
                  </div>
                <?php endif; ?>
              </div>
            </div>
            <?php if ($id == $this->session->userdata['user_id']): ?>
            <div class="col-md-3 btn-profile-wrapper">
                <button class="button edit-profile-btn">Edit</button>
                    <button class="button save-profile-btn edit-item hidden" data-href="<?php echo site_url('profile/load_profile'); ?>">Save</button>
                <button class="button settings-profile-btn" data-href="<?php echo site_url('settings'); ?>">Settings</button>
            </div>
          <?php endif; ?>
        </div>
    </div>
</div>
<div class="main col-md-10 col-md-offset-2 profile-nav-wrapper">
    <div class="row">
        <ul class="col-md-12 profile-nav nav nav-tabs">
            <li class="col-md-3" role="presentation"><a class="active" href="" data-href="<?php echo site_url('profile/load_postcards/'.$id.'/1'); ?>">Collection</a></li>
            <li class="col-md-3" role="presentation"><a href="" data-href="<?php echo site_url('profile/load_postcards/'.$id.'/2'); ?>">Favorites</a></li>
            <li class="col-md-3" role="presentation"><a href="" data-href="<?php echo site_url('profile/load_postcards/'.$id.'/3'); ?>">Swap</a></li>
            <li class="col-md-3" role="presentation"><a href="" data-href="<?php echo site_url('profile/load_postcards/'.$id.'/4'); ?>">Stats</a></li>
        </ul>
    </div>
</div>
<div class="main col-md-10 col-md-offset-2 profile-content-wrapper">
