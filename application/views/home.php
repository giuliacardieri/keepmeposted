<h2>Welcome, <?php echo $fname; ?></h2>
</div>
<div class="main col-md-10 col-md-offset-2 recommendations-wrapper">
    <h3>Recommended For You</h3>
    <div class="postcards-wrapper-smaller">
        <?php if (!empty($recommendations)): ?>
          <?php foreach ($recommendations as $key => $postcard): ?>
            <div class="postcard col-md-3" data-href="<?php echo site_url($postcard['owner'] . '/postcard/' . $postcard['id']) ?>">
                <div class="postcard-img-wrapper">
                  <div class="postcard-extra hidden">
                    <div class="img-overlay"></div>
                    <div class="postcard-info">
                        <p><?php echo $postcard['description'] ?><img class="country-flag" src="<?php echo asset_url('images/' . $postcard['country'] . '.png'); ?>"></p>
                        <p class="small">by
                            <?php if ($postcard['owner'] == $username) { echo 'You'; } else { echo $postcard['owner']; } ?></p>
                    </div>
                      <p class="icons favorite-icon remove <?php if (!$postcard['is_favorite']) echo 'hidden'; ?>" data-href="<?php echo site_url('favorites/remove_favorite/' . $postcard['id']) ?>"><span class="glyphicon glyphicon-star"></span></p>
                      <p class="icons favorite-icon add <?php if ($postcard['is_favorite']) echo 'hidden'; ?>" data-href="<?php echo site_url('favorites/add_favorite/' . $postcard['id']) ?>"><span class="glyphicon glyphicon-star-empty"></span></p>
                </div>
                    <img class="smaller" src="<?php echo asset_url('postcards/' . $postcard['photo']); ?>">
                </div>
            </div>
          <?php endforeach; ?>
        <?php else: echo '<p>No recommendations available.</p>'; ?>
        <?php endif; ?>
    </div>
</div>
<div class="main col-md-10 col-md-offset-2 recommendations-wrapper">
    <h3>Popular Postcards</h3>
    <div class="postcards-wrapper-smaller">
        <?php if (!empty($popular_recommendations)): ?>
          <?php foreach ($popular_recommendations as $key => $postcard): ?>
            <div class="postcard col-md-3" data-href="<?php echo site_url($postcard['owner'] . '/postcard/' . $postcard['id']) ?>">
                <div class="postcard-img-wrapper">
                  <div class="postcard-extra hidden">
                    <div class="img-overlay"></div>
                    <div class="postcard-info">
                        <p><?php echo $postcard['description'] ?><img class="country-flag" src="<?php echo asset_url('images/' . $postcard['country'] . '.png'); ?>"></p>
                        <p class="small">by
                            <?php if ($postcard['owner'] == $username) { echo 'You'; } else { echo $postcard['owner']; } ?></p>
                    </div>
                      <p class="icons favorite-icon remove <?php if (!$postcard['is_favorite']) echo 'hidden'; ?>" data-href="<?php echo site_url('favorites/remove_favorite/' . $postcard['id']) ?>"><span class="glyphicon glyphicon-star"></span></p>
                      <p class="icons favorite-icon add <?php if ($postcard['is_favorite']) echo 'hidden'; ?>" data-href="<?php echo site_url('favorites/add_favorite/' . $postcard['id']) ?>"><span class="glyphicon glyphicon-star-empty"></span></p>
                </div>
                    <img class="smaller" src="<?php echo asset_url('postcards/' . $postcard['photo']); ?>">
                </div>
            </div>
          <?php endforeach; ?>
        <?php else: echo '<p>No recommendations available.</p>'; ?>
        <?php endif; ?>
    </div>
</div>
