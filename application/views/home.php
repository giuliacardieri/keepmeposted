<h2>Welcome, <?php echo $fname; ?></h2>
  <?php if (!empty($popular)): ?>
    <div class="popular-postcard-wrapper row">
      <div class="col-md-3">
        <div class="row">
          <div class="col-md-12 stats-square">
            <div class="square-wrapper">
              <h2><?php echo $collection_count; ?></h2>
              <p>Postcards</p>
            </div>      
          </div> 
        </div>
        <div class="row"> 
          <div class="col-md-12 stats-square">
            <div class="square-wrapper color-2">
              <h2><span class="stats-icon glyphicon glyphicon-star"></span><?php echo $favorites_count; ?></h2>
              <p>Favorites</p>
            </div>      
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 stats-square">
            <div class="square-wrapper color-3">
              <h2><span class="stats-icon glyphicon glyphicon-globe"></span><?php echo $country_count; ?></h2>
              <p>Countries</p>
            </div>      
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 stats-square">
            <div class="square-wrapper color-4">
              <h2><span class="stats-icon glyphicon glyphicon-list"></span><?php echo $popular_category[0]['name']; ?></h2>
              <p>Most popular category</p>
            </div>      
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="postcard" data-href="<?php echo site_url($username. '/postcard/' . $popular[0]['id']) ?>">
            <div class="postcard-img-wrapper">
              <div class="postcard-extra hidden">
                <div class="img-overlay"></div>
                <div class="postcard-info">
                    <p><?php echo $popular[0]['description'] ?><img class="country-flag" src="<?php echo asset_url('images/' . $popular[0]['country'] . '.png'); ?>"></p>
                    <p class="small">by You</p>
                </div>
                  <p class="icons favorite-icon remove <?php if (!$popular[0]['is_favorite']) echo 'hidden'; ?>" data-href="<?php echo site_url('favorites/remove_favorite/' . $popular[0]['id']) ?>"><span class="glyphicon glyphicon-star"></span></p>
                  <p class="icons favorite-icon add <?php if ($popular[0]['is_favorite']) echo 'hidden'; ?>" data-href="<?php echo site_url('favorites/add_favorite/' . $popular[0]['id']) ?>"><span class="glyphicon glyphicon-star-empty"></span></p>
              </div>
              <img class="img-responsive" src="<?php echo asset_url('postcards/' . $popular[0]['photo']); ?>">
            </div>
        </div>  
        <div class="row">
          <div class="col-md-12">
            <h4>Most popular postcard from your postcards</h4>
          </div>
        </div>
      </div>  
    </div>
  <?php endif; ?>
<div class="favorite-categories-wrapper">
    <div class="row">
        <div class="col-md-12">
          <h2>Favorite Categories<span class="glyphicon glyphicon-pencil" data-href="<?php echo site_url('settings'); ?>"></span></h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php if (empty($category)): ?>
              <button class="button fav-category-btn" data-href="<?php echo site_url('settings'); ?>">Choose favorite categories</button>
            <?php else: ?>
            <div class="chip-wrapper">
              <?php foreach ($category as $item): ?>
                <p class="chip"><?php echo $item['name']; ?></p>
              <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
</div>
<div class="main col-md-10 col-md-offset-2 recommendations-wrapper popular">
    <h3>Popular Postcards</h3>
    <div class="postcards-wrapper-smaller row">
        <?php if (!empty($popular_recommendations)): ?>
          <?php foreach ($popular_recommendations as $key => $postcard): ?>
          <?php if ($key == 4): ?>
            <div class="postcards-extra hidden">
          <?php endif; ?>
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
            <?php if ($key == sizeof($popular_recommendations) - 1 && sizeof($popular_recommendations)>4): ?>
              </div>
            <?php endif; ?>
          <?php endforeach; ?>
        <?php else: echo '<p>No recommendations available.</p>'; ?>
        <?php endif; ?>
    </div>
    <?php if (sizeof($popular_recommendations) > 4): ?>
      <div class="row">
        <div class="btn-wrapper col-md-12">
          <button class="button btn-more">See More</button>
        </div>
      </div>
    <?php endif; ?>
</div>
<?php if (!is_null($recommendations)): ?>
  <div class="main col-md-10 col-md-offset-2 recommendations-wrapper personal">
      <h3>Recommended For You</h3>
      <div class="postcards-wrapper-smaller row">
          <?php if (!empty($recommendations)): ?>
            <?php foreach ($recommendations as $key => $postcard): ?>
            <?php if ($key == 4): ?>
              <div class="postcards-extra hidden">
            <?php endif; ?>
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
              <?php if ($key == sizeof($recommendations) - 1 && sizeof($recommendations)>4): ?>
                </div>
            <?php endif; ?>
            <?php endforeach; ?>
          <?php else: echo '<p>No recommendations available.</p>'; ?>
          <?php endif; ?>
      </div>
      <?php if (sizeof($recommendations) > 4): ?>
        <div class="row">
          <div class="btn-wrapper col-md-12">
            <button class="button btn-more">See More</button>
          </div>
        </div>
      <?php endif; ?>
  </div>
<?php endif; ?>
