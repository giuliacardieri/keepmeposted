<div class="row">
    <h2>Settings</h2>
</div>

<div class="row">
    <form class="settings-form" data-href="<?php echo site_url('settings/update'); ?>" method="post" data-parsley-validate>
        <div class="row">
            <div class="settings-group col-md-12">
                <h4>Account</h4>
                <div class="row">
                    <div class="form-field col-md-6">
                        <label class="label-selected username-label" for="username">Username</label>
                        <input type="text" id="username" name="username" value="<?php echo $username; ?>" required data-parsley-length="[5, 20]" data-parsley-errors-container=".username">
                        <p class="username field-error hidden"></p>
                    </div>

                    <div class="form-field col-md-6">
                        <label class="label-selected email-label" for="email">Email</label>
                        <input type="email" id="email" value="<?php echo $email; ?>" name="email" data-parsley-errors-container=".email">
                        <p class="email field-error hidden"></p>
                    </div>

                    <div class="form-field col-md-6">
                        <label class="label-selected password-label" for="password">Password</label>
                        <input type="password" id="password" name="password" data-parsley-errors-container=".password" data-parsley-length="[8, 50]">
                        <p class="field-error password hidden"></p>
                    </div>

                    <div class="form-field col-md-6">
                        <label class="label-selected password-label" for="password">Confirm Password</label>
                        <input type="password" id="password-confirm" name="password-confirm" data-parsley-errors-container=".password-confirm" data-parsley-length="[8, 50]" data-parsley-equalto="#password">
                        <p class="field-error password-confirm hidden"></p>
                    </div>
                </div>
            </div>
        </div>
            <div class="row">
                <div class="settings-group col-md-12">
                    <h4>Favorite Categories</h4>
                    <p>Choose up to three favorite categories.</p>
                    <div class="row">
                        <div class="categories-wrapper col-md-12">
                            <div class="chip-wrapper">
                            <?php if (!empty($category)): ?>
                                    <?php foreach ($category as $key => $name): ?>
                                        <p class="chip chip-<?php echo $name['id']; ?>"><?php echo $name['name']; ?><span class="close-option">x</span></p>
                                        <input name="chip-<?php echo $name['id']; ?>" class="chip-<?php echo $name['id']; ?>"id="<?php echo $name['id']; ?>" type="hidden" value="<?php echo $name['name']; ?>"/>
                                    <?php endforeach; ?>
                            <?php endif; ?>
                            </div>
                            <div class="new-chip hidden">
                                <select id="new-chip" name="new-chip" data-parsley-errors-container=".new-category">
                                    <option value="">Choose a category</option>
                                    <?php foreach ($categories as $categories): ?>
                                        <option class="<?php echo $categories['id']; ?>" value="<?php echo $categories['name'] ?>">
                                            <?php echo $categories['name']?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <button class="button btn-add-chip-select">Add</button>
                            </div>
                            <p class="chip-helper <?php if (sizeof($category) > 2) { echo 'hidden'; } ?>">+ Add new category</p>
                            <p class="new-category field-error hidden"></p>
                        </div>
                    </div>
                </div>
            </div>
        <div class="row">
            <div class="settings-group col-md-12">
                <h4>Social Media</h4>
                <p>Show social media information on your profile.</p>
                <div class="row">
                    <div class="form-field col-md-6">
                        <label class="label-selected postcrossing-label" for="postcrossing">Postcrossing Profile</label>
                        <input type="text" id="postcrossing" name="postcrossing" value="<?php echo $postcrossing; ?>" data-parsley-errors-container=".postcrossing">
                        <p class="postcrossing field-error hidden"></p>
                    </div>

                    <div class="form-field col-md-6">
                        <label class="label-selected forum-label" for="forum">Postcrossing Forum Profile</label>
                        <input type="text" id="forum" value="<?php echo $forum; ?>" name="postcrossing_forum" data-parsley-errors-container=".forum">
                        <p class="field-error forum hidden"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="form-field col-md-6">
                        <label class="label-selected twitter-label" for="twitter">Twitter</label>
                        <input type="text" id="twitter" name="twitter" value="<?php echo $twitter; ?>" data-parsley-errors-container=".twitter-errors">
                        <p class="twitter-errors field-error hidden"></p>
                    </div>

                    <div class="form-field col-md-6">
                        <label class="label-selected facebook-label" for="facebook">Facebook</label>
                        <input type="text" id="facebook" value="<?php echo $facebook; ?>" name="facebook" data-parsley-errors-container=".facebook-errors">
                        <p class="field-error facebook-errors hidden"></p>
                    </div>
                </div>
            </div>
        </div>
       <!--  <div class="row">
            <div class="settings-group col-md-12">
                <h4>Sharing</h4>
                <p>Share your new postcards and favorited postcards on social networks.</p>
                <div class="row">
                    <div class="form-field col-md-6">
                        <label class="settings-label twitter-label" for="twitter">Twitter</label>
                        <input id="share_twitter" type="checkbox" name="share_twitter" value="<?php echo $share_twitter; ?>" <?php if ($share_twitter==1 ) { echo 'checked'; } ?>>
                    </div>
                    <div class="form-field col-md-6">
                        <label class="settings-label facebook-label" for="facebook">Facebook</label>
                        <input id="share_facebook" type="checkbox" name="share_facebook" value="<?php echo $share_facebook; ?>" <?php if ($share_facebook==1 ) { echo 'checked'; } ?>>
                    </div>
                </div>
            </div>
        </div> -->
<!--         <div class="row">
            <div class="settings-group col-md-12">
                <h4>Email Notifications</h4>
                <p>Receive emails when someone favorite one of your postcards.</p>
                <div class="row">
                    <div class="form-field col-md-6">
                        <label class="settings-label favorite-email" for="favorite-email">Get email notifications</label>
                        <input id="favorite-email" type="checkbox" name="favorite-email" value="<?php echo $favorite_email; ?>" <?php if ($favorite_email==1 ) { echo 'checked'; } ?>>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="row">
            <div class="col-md-12 button-wrapper-settings">
                <div class="row">
                    <div class="col-md-6 button-wrapper-delete">
                        <button class="button delete-account-btn" data-toggle="modal" data-target="#deleteModal">Delete Account</button>
                    </div>
                    <div class="col-md-6 button-wrapper">
                        <input name="submit2" class="settings-submit" type="submit" value="Save">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
