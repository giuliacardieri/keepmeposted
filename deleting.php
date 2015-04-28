<?php $title="Delete Postcard" ; ?>
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
          <h2>Do you really want to delete the postcard <?php echo $postcard->id ?>?</h2>
          
          <div class="delete-container">
            <img class="delete-img" src="data:image/jpeg;base64,<?php echo base64_encode( $postcard->photo ); ?>" />
            
            <div class="delete-text-container">
              <h3><?php echo $postcard->description ?></h3>

              <p>Sent by
                <?php echo $postcard->sender ?> - <?php echo $postcard->country ?>
                <img class="flag" src="images/<?php echo array_search($postcard->country, $countries); ?>.png" alt="flag" />
              </p>
              
              <p><?php echo $types[$postcard->type] ?> - <?php echo $state[$postcard->state] ?></p>

              <p>Data: <?php echo $postcard->date ?></p>

              <?php if ($postcard->postcrossing_id): ?>
              <p>Postcrossing ID:
                <?php echo $postcard->postcrossing_id; ?></p>
              <?php endif; ?>

              <form action="delete.php" method="post">
                <input type="submit" value="Delete" />
                <input class="hidden" type="text" name="id" value="<?php echo $postcard->id ?>">
              </form>
            </div>
            </div>
            
            <?php else: ?>
            <h2>Oh No! Postcard not found!</h2>
            <?php endif; ?>
            
            <div class="col-md-12 buttons">
              <button class="button back">Back</button>
            </div>
            
          </div>
      </main>
      </div>
    </div>

</body>
</html>
