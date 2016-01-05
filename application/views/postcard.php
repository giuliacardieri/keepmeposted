<div class="row">
    <div class="postcard-container col-md-12">
    <form id="postcard-update" method="post" action="<?php echo site_url('postcard/edit_postcard'); ?>">
        <div class="row">
          <div class="postcard-load">
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
                    <?php if (is_null($postcard['owner'])) echo 'You'; else echo "<a href='" . site_url('profile/' . $postcard['owner']) . "'>" . $postcard['owner'] . "</a>";?></p>
                <p class="flag-sibling">
                    <span class="glyphicon glyphicon-map-marker"></span>
                    <?php if ($postcard['is_swap'] == 0) { echo 'Sent by ' . $postcard['sender']. ' - '; } ?>
                <?php echo $country_name; ?></p>
                <img class="country-flag" src="<?php echo asset_url('images/' . $postcard['country'] . '.png'); ?>">

                <?php if ($postcard['is_swap'] == 0): ?>
                    <p><span class="glyphicon glyphicon-calendar"></span>Received on <?php echo $postcard['date_received'] ?></p>
                    <p><span class="glyphicon glyphicon-info-sign"></span><?php echo $postcard['type']; ?></p>
                    <p><span class="glyphicon glyphicon-pushpin"></span><?php echo $postcard['state'] ?></p>

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

          <!-- editable fields -->
            <?php if (is_null($postcard['owner'])): ?>
            <div class="postcard-text-container edit-postcard hidden col-md-5">
            		<div class="row">
            				<div class="edit-field col-md-12">
            						<input type="text" id="description" name="description" data-parsley-required="true" data-parsley-length="[10, 250]" data-parsley-errors-container=".description" value="<?php echo $postcard['description'] ?>">
            						<p class="description field-error hidden"></p>
            				</div>
            		</div>
            		<div class="row hidden">
            			<p class="edit-field col-md-6"><span class="glyphicon glyphicon-user"></span>By
            					<?php if (is_null($postcard['owner'])) echo 'You'; else echo $postcard['owner'];?></p>
            		</div>
            		<div class="row">
            				<?php if ($postcard['is_swap'] == 0) :?>
            					<p class="edit-field col-xs-3 col-sm-3 col-md-3"><span class="glyphicon glyphicon-map-marker"></span>Sent by</p>
            				    <div class="edit-field col-xs-4 col-sm-4 col-md-5">
            						<input type="text" id="sender" class="received-attr" name="sender" value="<?php echo $postcard['sender']; ?>" data-parsley-errors-container=".sender" data-parsley-required="true">
            						<p class="field-error sender hidden"></p>
            				    </div>
            				<?php else: ?>
            						<p class="edit-field col-xs-1 col-sm-1 col-md-1"><span class="glyphicon glyphicon-map-marker"></span>
            				<?php endif; ?>
            				<div class="edit-field col-xs-5 col-sm-5 col-md-4">
            						<select id="country" name="country" data-parsley-errors-container=".country" data-parsley-required="true">
            								<option value="">Choose a country</option>
            								<?php foreach ($countries as $country ): ?>
            								<option value="<?php echo $country['id'] ?>" <?php if ($country['id'] == $postcard['country']) { echo 'selected';} ?>>
            										<?php echo $country['name'] ?>
            								</option>
            								<?php endforeach; ?>
            						</select>
            						<p class="field-error country hidden"></p>
            				</div>
            		</div>

            		<?php if ($postcard['is_swap'] == 0): ?>
            				<div class="row">
            						<p class="edit-field col-xs-5 col-sm-5 col-md-4"><span class="glyphicon glyphicon-calendar"></span>Received on</p>
            						<div class="edit-field col-xs-6 col-sm-6 col-md-6">
            								<input type="text" id="datepicker-edit" class="received-attr" name="date" data-parsley-errors-container=".date" data-parsley-required="true">
            								<p class="field-error date hidden"></p>
            						</div>
            				</div>
            				<script>
            						var postcardDate = '<?php echo $postcard['date_received']; ?>';
            						$( "#datepicker-edit" ).datepicker().val(postcardDate);
            				</script>
            				<div class="row">
            						<div class="edit-field col-md-6">
            								<select id="type" name="type" class="received-attr" data-parsley-errors-container=".type" data-parsley-required="true">
            										<option value="">Choose a swap type</option>
            										<?php foreach ($types as $name=>$type ): ?>
            										<option value="<?php echo $type ?>" <?php if ($postcard['type'] == $type) { echo 'selected'; } ?>>
            												<?php echo $type?>
            										</option>
            										<?php endforeach; ?>
            								</select>
            								<p class="field-error type hidden"></p>
            						</div>
            						<div class="edit-field col-md-6">
            								<select id="state" name="state" data-parsley-errors-container=".state" data-parsley-required="true">
            										<option value="">Choose a state</option>
            										<?php foreach ($states as $name=>$state ): ?>
            										<option value="<?php echo $state?>" <?php if ($postcard['state'] == $state) { echo 'selected'; } ?>>
            												<?php echo $state?>
            										</option>
            										<?php endforeach; ?>
            								</select>
            								<p class="field-error state hidden"></p>
            						</div>
            				</div>

            				<?php if ($postcard['postcrossing_id']): ?>
            				<div class="row">
            						<div class="edit-field">
            								<p class="col-md-4 edit-field">Postcrossing ID:</p>
            								<div class="edit-field col-md-8">
            										<input type="text" id="postcrossing-id" name="postcrossing-id" data-parsley-errors-container=".postcrossing-id" data-parsley-pattern="[A-Z]{2}[-]\d{1,8}" value="<?php echo $postcard['postcrossing_id']; ?>" data-parsley-error-message="Valid format: ID-1234">
            										<p class="field-error postcrossing-id hidden"></p>
            								</div>
            						</div>
            				</div>
            				<input id="swap" type="hidden" name="swap" value="0">
            				<?php endif; ?>

            		<?php else: ?>
            				<input id="swap" type="hidden" name="swap" value="1">

            				<div class="row">
            						<p class="edit-field col-xs-4 col-sm-4 col-md-3"><span class="glyphicon glyphicon-send"></span>For swap</p>
            						<div class="edit-field hidden col-xs-6 col-sm-6 col-md-6">
            								<select id="available" name="available" data-parsley-errors-container=".available" data-parsley-required="true">
            										<option value="1" <?php if ($postcard['is_available'] == 1) { echo 'selected'; } ?>>Available</option>
            										<option value="0" <?php if ($postcard['is_available'] == 0) { echo 'selected'; } ?>>Not available</option>
            								</select>
            								<p class="field-error available hidden"></p>
            						</div>
            				</div>

            		<?php endif; ?>

            		<input id="id" type="hidden" name="id" value="<?php echo $postcard['id']; ?>">
                <input id="tags-value" type="hidden" name="tags-value" value="<?php foreach ($tags as $key => $tag){ echo $key . ','; }?>">

            		<div class="row">
            				<p class="edit-field col-xs-1 col-sm-1 col-md-1"><span class="glyphicon glyphicon-th-list"></span></p>
            				<div class="edit-field col-xs-6 col-sm-6 col-md-6">
            						<select id="category" name="category" data-parsley-errors-container=".category" data-parsley-required="true">
            								<option value="">Choose a category</option>
            								<?php foreach ($categories as $categories): ?>
            								<option value="<?php echo $categories['id'] ?>" <?php if ($postcard['category_id'] == $categories['id']) { echo 'selected'; } ?>>
            										<?php echo $categories['name']?>
            								</option>
            								<?php endforeach; ?>
            						</select>
            						<p class="field-error category hidden"></p>
            				</div>
            		</div>
                <div class="row">
                    <div class="edit-field tags-wrapper-postcard col-md-12">
                        <div class="chip-wrapper">
                        <?php if (!empty($tags)): ?>
                                <?php foreach ($tags as $key => $tag): ?>
                                    <p data-input-ref="<?php echo $key; ?>" class="chip chip-<?php echo $key; ?>"><?php echo $tag['tagname']; ?><span class="close-option">x</span></p>
                                    <input name="chip-<?php echo $key; ?>" class="chip-<?php echo $key; ?>"id="<?php echo $key; ?>" type="hidden" value="<?php echo $tag['tagname']; ?>"/>
                                <?php endforeach; ?>
                        <?php endif; ?>
                        </div>
                        <div class="new-chip hidden">
                            <input type="text" id="new-chip" class="postcard-chip" name="new-chip" data-parsley-errors-container=".new-tags">
                            <button class="button btn-add-chip">Add</button>
                        </div>
                        <p class="chip-helper <?php if (sizeof($tags) > 4) { echo 'hidden'; } ?>">+ Add tags</p>
                        <p class="new-tags field-error hidden"></p>
                    </div>
                </div>
              </div>
            </form>
          <?php endif; ?>

            <!-- btn wrapper -->
            <div class="col-xs-12 col-sm-12 col-md-5 button-postcard-wrapper">
                <button class="button remove-favorite <?php if ($is_favorite == 0) { echo 'hidden';} ?>" data-href="<?php echo site_url('favorites/remove_favorite/'. $postcard['id']); ?>">Remove from Favorites</button>
                <button class="button add-favorite <?php if ($is_favorite == 1) { echo 'hidden';} ?>" data-href="<?php echo site_url('favorites/add_favorite/'. $postcard['id']); ?>">Add to Favorites</button>
                <?php if(is_null($postcard['owner'])): ?>
                  <button class="button" data-toggle="modal" data-target="#deleteModal">Delete</button>
                  <button class="button edit-btn">Edit</button>
                  <button class="button save-btn hidden" data-href="<?php echo site_url('postcard/load_postcard_info/'.$postcard['id']); ?>">Save</button>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 buttons">
            <button class="button back">Back</button>
        </div>
    </div>
</div>
