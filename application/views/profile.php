    <div class="row">
        <div class="col-md-12 profile-wrapper">
          <form id="form-profile" class="profile-info-text" method="post" action="<?php echo site_url('profile/update_profile'); ?>" data-parsley-validate>
            <div class="profile-load">
              <div class="col-xs-4 col-xs-offset-4 col-sm-4 col-sm-offset-4 col-md-3 profile-img-wrapper">
                  <img src="<?php echo asset_url('users/' . $photo); ?>">
                  <div class="profile-img-overlay edit-item hidden"></div>
                  <div class="profile-img-edit edit-item hidden">
                        <span class="glyphicon glyphicon-camera hidden"></span>
                        <input type="file" id="photo" name="photo" accept="image/*" data-parsley-errors-container=".photo"/>
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
                      <?php if (!is_null($postcrossing) && $show_postcrossing== 1): ?>
                        <p><img class="icon" src="<?php echo asset_url('images/postcrossing-icon.png'); ?>" alt="twitter icon" /><a href="http://postcrossing.com/user/<?php echo $postcrossing; ?>" target="blank"><?php echo $postcrossing; ?></a></p>
                      <?php endif; ?>
                      <?php if (!is_null($postcrossing_forum) && $show_forum == 1): ?>
                        <p><img class="icon" src="<?php echo asset_url('images/forum-icon.png'); ?>" alt="twitter icon" /><a href="http://forum.postcrossing.com/member.php?action=viewpro&member=<?php echo $postcrossing_forum; ?>" target="blank"><?php echo $postcrossing_forum; ?></a></p>
                      <?php endif; ?>                 
                  </div>
              </div>
            </div>
              <!-- editable fields -->
            <div class="col-md-6 profile-edit-wrapper edit-item hidden">
                  <div class="row">
                      <div class="edit-field col-xs-5 col-sm-5 col-md-5">
                          <input type="text" id="fname" name="fname" data-parsley-required="true" data-parsley-length="[2, 25]" data-parsley-errors-container=".fname" value="<?php echo $fname; ?>">
                          <p class="fname field-error hidden"></p>
                      </div>
                      <div class="edit-field col-xs-6 col-sm-6 col-md-6">
                          <input type="text" id="lname" name="lname" data-parsley-required="true" data-parsley-length="[1, 50]" data-parsley-errors-container=".lname" value="<?php echo $lname; ?>">
                          <p class="lname field-error hidden"></p>
                      </div>
                  </div>
                  <div class="row">
                    <p class="edit-field col-xs-6 col-sm-6 col-md-6"><span class="glyphicon glyphicon-user"></span><?php echo $username; ?></p>
                  </div>
                  <div class="row">
                      <p class="edit-field col-xs-3 col-sm-3 col-md-3"><span class="glyphicon glyphicon-map-marker"></span></span>From </p>
                      <div class="edit-field col-xs-6 col-sm-6 col-md-4">
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
                  <div class="row">
                      <p class="edit-field col-xs-1 col-sm-1 col-md-1"><img class="icon" src="<?php echo asset_url('images/fb-icon.png'); ?>" alt="facebook icon" /></p>
                      <div class="edit-field col-xs-5 col-sm-5 col-md-5">
                          <input type="text" id="facebook" name="facebook" data-parsley-errors-container=".facebook" value="<?php echo $facebook; ?>">
                          <p class="facebook field-error hidden"></p>
                      </div>
                      <div class="edit-field col-xs-3 col-sm-3 col-md-3">
                          <label class="private-label" for="show-facebook">Private</label>
                          <input id="show-facebook" type="checkbox" name="show-facebook" value="<?php echo $show_facebook; ?>" <?php if ($show_facebook == 0 ) { echo 'checked'; } ?>>
                      </div>
                  </div>
                  <div class="row">
                      <p class="edit-field col-xs-1 col-sm-1 col-md-1"><img class="icon" src="<?php echo asset_url('images/tw-icon.png'); ?>" alt="twitter icon" /></p>
                      <div class="edit-field col-xs-5 col-sm-5 col-md-5">
                          <input type="text" id="twitter" name="twitter" data-parsley-errors-container=".twitter" value="<?php echo $twitter; ?>">
                          <p class="twitter field-error hidden"></p>
                      </div>
                      <div class="edit-field col-xs-3 col-sm-3 col-md-3">
                          <label class="private-label" for="show-twitter">Private</label>
                          <input id="show-twitter" type="checkbox" name="show-twitter" value="<?php echo $show_twitter; ?>" <?php if ($show_twitter == 0 ) { echo 'checked'; } ?>>
                      </div>
                  </div>
                  <div class="row">
                      <p class="edit-field col-xs-1 col-sm-1 col-md-1"><img class="icon" src="<?php echo asset_url('images/postcrossing-icon.png'); ?>" alt="twitter icon" /></p>
                      <div class="edit-field col-xs-5 col-sm-5 col-md-5">
                          <input type="text" id="postcrossing" name="postcrossing" data-parsley-errors-container=".postcrossing" value="<?php echo $postcrossing; ?>">
                          <p class="postcrossing field-error hidden"></p>
                      </div>
                      <div class="edit-field col-xs-3 col-sm-3 col-md-3">
                          <label class="private-label" for="show-postcrossing">Private</label>
                          <input id="show-postcrossing" type="checkbox" name="show-postcrossing" value="<?php echo $show_facebook; ?>" <?php if ($show_postcrossing == 0 ) { echo 'checked'; } ?>>
                      </div>
                  </div>
                  <div class="row">
                      <p class="edit-field col-xs-1 col-sm-1 col-md-1"><img class="icon" src="<?php echo asset_url('images/forum-icon.png'); ?>" alt="twitter icon" /></p>
                      <div class="edit-field col-xs-5 col-sm-5 col-md-5">
                          <input type="text" id="postcrossing_forum" name="postcrossing_forum" data-parsley-errors-container=".postcrossing_forum" value="<?php echo $postcrossing_forum; ?>">
                          <p class="postcrossing_forum field-error hidden"></p>
                      </div>
                      <div class="edit-field col-xs-3 col-sm-3 col-md-3">
                          <label class="private-label" for="show-forum">Private</label>
                          <input id="show-forum" type="checkbox" name="show-forum" value="<?php echo $show_facebook; ?>" <?php if ($show_forum == 0 ) { echo 'checked'; } ?>>
                      </div>
                  </div>
              </form>
            </div>
            <?php if ($id == $this->session->userdata['user_id']): ?>
            <div class="col-md-4 btn-profile-wrapper">
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
        <ul class="col-md-12 profile-nav nav nav-tabs nav-justified">
            <li class="col-md-3" role="presentation"><a class="active" href="" data-href="<?php echo site_url('profile/load_postcards/'.$id.'/1'); ?>">Collection</a></li>
            <li class="col-md-3" role="presentation"><a href="" data-href="<?php echo site_url('profile/load_postcards/'.$id.'/2'); ?>">Favorites</a></li>
            <li class="col-md-3" role="presentation"><a href="" data-href="<?php echo site_url('profile/load_postcards/'.$id.'/3'); ?>">Swap</a></li>
            <li class="col-md-3" role="presentation"><a class="stats" href="" data-href="<?php echo site_url('profile/load_stats/'.$id); ?>">Stats</a></li>
        </ul>
    </div>
</div>
<div class="main col-md-10 col-md-offset-2 profile-content-wrapper">
