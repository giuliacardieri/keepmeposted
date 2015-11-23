    <?php if (!is_null($postcard) && !empty($postcard)): ?>
        <?php foreach ($postcard as $key => $postcard_item): ?>
                <div class="postcard col-md-3" data-href="<?php echo site_url($postcard_item['url_attr'] . '/postcard/' . $postcard_item['id']) ?>">
                    <div class="postcard-img-wrapper">
                          <div class="postcard-extra hidden">
                            <div class="img-overlay"></div>
                            <div class="postcard-info">
                                <p><?php echo $postcard_item['description'] ?><img class="country-flag" src="<?php echo asset_url('images/' . $postcard_item['country'] . '.png'); ?>"></p>
                                <p class="small">by
                                    <?php if ($postcard_item['owner'] == $logged_user) { echo 'You'; } else { echo $postcard_item['owner']; } ?></p>
                            </div>
                              <p class="icons favorite-icon remove <?php if (!$postcard_item['is_favorite']) echo 'hidden'; ?>" data-href="<?php echo site_url('favorites/remove_favorite/' . $postcard_item['id']) ?>"><span class="glyphicon glyphicon-star"></span></p>
                              <p class="icons favorite-icon add <?php if ($postcard_item['is_favorite']) echo 'hidden'; ?>" data-href="<?php echo site_url('favorites/add_favorite/' . $postcard_item['id']) ?>"><span class="glyphicon glyphicon-star-empty"></span></p>
                        </div>
                        <img class="smaller" src="<?php echo asset_url('postcards/' . $postcard_item['photo']); ?>">
                    </div>
                </div>
        <?php endforeach; ?>
    <?php else: ?>
    <p class="col-md-12">No postcards from your were found.</p>
    <?php endif; ?>
</div>
</div>
