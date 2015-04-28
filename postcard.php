<?php $title="Postcard" ; ?>
<?php include_once 'globals.php'; ?>
<?php include_once 'includes/head.php'; ?>
<?php require_once 'classes/repository.php' ?>
<?php $id=filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING); if (!is_numeric($id) || !$id) { header( 'Location: ' . SITE_DIR); exit; } $postcard=repository::getPostcardId($id); ?>

<body>
  <div class="container-fluid">
    <?php include_once 'includes/nav.php' ?>
    <div class="content">
      <?php include_once 'includes/header.php' ?>
      <main class="row">
        <div class="main-container">
          <?php if ($postcard): ?>
          <h2>Postcard <?php echo $postcard->id ?></h2>
          
          <div class="postcard-container">

            <div class="img-container">
              <img class="postcard-img" src="data:image/jpeg;base64,<?php echo base64_encode( $postcard->photo ); ?>" />
            </div>
            <div class="postcard-text-container">
              <h3><?php echo $postcard->description ?></h3>

              <p>Sent by
                <?php echo $postcard->sender ?> -
                <?php echo $postcard->country ?>
                <img class="flag" src="images/<?php echo array_search($postcard->country, $countries); ?>.png" alt="flag" />
              </p>
              <p><?php echo $types[$postcard->type] ?> - <?php echo $state[$postcard->state] ?></p>

              <p>Date:
                <?php echo $postcard->date ?></p>

              <?php if ($postcard->postcrossing_id): ?>
              <p>Postcrossing ID:
                <?php echo $postcard->postcrossing_id; ?></p>
              <?php endif; ?>

              <div class="clicable tags" data-href="<?php echo 'show_category.php?category=' . $postcard->category ?>">
                <span class="postcard-icon glyphicon glyphicon-tag"></span>
                <?php echo $categories[$postcard->category] ?>
              </div>
            
            <?php if ($postcard->favorite == 1): ?>
            <div class="clicable fav">
                  <span class="glyphicon glyphicon-star"></span>
                Favorite
            </div>
            <?php endif; ?>
            
            </div>

          </div>
          
          <?php else: ?>
          <h2>Oh No! Postcard not found!</h2>
          <?php endif; ?>
          
          <div class="col-md-12 buttons">
            <button class="button back">Back</button>
            <button class="button remove" data-href="<?php echo 'deleting.php?id=' . $postcard->id ?>">Delete</button>
            <button class="button edit-btn" data-href="<?php echo 'edit.php?id=' . $postcard->id ?>">Edit</button>
          </div>
        </div>
      </main>
    </div>

  </div>
</body>
</html>
