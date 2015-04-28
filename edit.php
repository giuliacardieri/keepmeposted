<?php $title="Edit Postcard" ; ?>
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
          <h2>Edit Postcard <?php echo $postcard->id ?></h2>
          <?php if ($postcard): ?>
          <form class="add_form" action="formUpdate.php" method="post" enctype="multipart/form-data">

            <div class="form-field col-md-6">
              <input type="text" id="description" name="description" placeholder="Description" value="<?php echo $postcard->description; ?>">
              <p class="error descriptionError hidden">The postcard must have a description!</p>
            </div>

            <div class="form-field col-md-6">
              <select id="category" name="category">
                <option value="null">Choose a Category</option>
                <?php foreach ($categories as $name=>$category ): ?>
                <option <?php if ($name==$postcard->category) echo "selected='selected'"; ?> value="
                  <?php echo $name ?>">
                  <?php echo $category?>
                </option>
                <?php endforeach; ?>
              </select>
              <p class="error categoryError hidden">Choose a category!</p>
            </div>

            <div class="form-field col-md-6">
              <input type="text" id="sender" name="sender" placeholder="Sender" value="<?php echo $postcard->sender; ?>">
              <p class="error senderError hidden">The postcard must have a sender!</p>
            </div>

            <div class="form-field col-md-6">
              <select id="state" name="state">
                <option value="null">Choose a state</option>
                <?php foreach ($state as $name=>$state ): ?>
                <option <?php if ($name==$postcard->state) echo "selected='selected'"; ?> value="
                  <?php echo $name ?>">
                  <?php echo $state?>
                </option>
                <?php endforeach; ?>
              </select>
              <p class="error stateError hidden">Choose a state!</p>
            </div>


            <div class="form-field col-md-6">
              <input type="text" id="postcrossing_id" name="postcrossing_id" placeholder="Postcrossing ID" <?php if($postcard->postcrossing-id !== null) echo "value='".$postcard->postcrossing-id."'"; ?>>
            </div>

            <div class="form-field col-md-6">
              <select id="type" name="type">
                <option value="null">Choose a Type</option>
                <?php foreach ($types as $name=>$type ): ?>
                <option <?php if ($name== $postcard->type) echo "selected='selected'"; ?> value="<?php echo $name ?>">
                  <?php echo $type ?>
                </option>
                <?php endforeach; ?>
              </select>
              <p class="error typeError hidden">Choose a type!</p>
            </div>

            <div class="form-field col-md-6">
              <label for="data">Date Received</label>
              <input value="<?php echo $postcard->date; ?>" type="date" id="date" name="date">
              <p class="error dateError hidden">Choose a date!</p>
            </div>

            <div class="form-field col-md-6">
              <select id="country" name="country">
                <option value="null">Choose a country</option>
                <?php foreach ($countries as $short=>$name ): ?>
                <option <?php if ($name== $postcard->country) echo "selected='selected'"; ?> value="
                  <?php echo $name ?>">
                  <?php echo $name?>
                </option>
                <?php endforeach; ?>
              </select>
              <p class="error countryError hidden">Choose a country!</p>
            </div>

            <div class="form-field col-md-6">
              <label for="photo">Image</label>
              <input type="file" id="photo" name="photo" value="">
              <p class="error photoError hidden">The image must be .png/.jpg/.jpeg!</p>
            </div>

            <div class="form-field col-md-6">
              <label class="favorite" for="photo">Favorite?</label>
              <input id="favorite" type="checkbox" name="favorite" value="1" checked="<?php if ($postcard->favorite == 1) echo 'true'; ?>">
            </div>

            <input class="hidden" type="text" name="id" value="<?php echo $postcard->id ?>">

            <div class="col-md-12 buttons">
              <input type="reset" value="Reset">
              <input type="submit" value="Send">
            </div>

          </form>

          <?php else: ?>
          <p>Oh No! The postcard ID is invalid!</p>
          <?php endif; ?>

        </div>
      </main>
    </div>

  </div>
</body>

</html>
