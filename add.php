<?php $title="Add" ; ?>
<?php include_once 'globals.php'; ?>
<?php include_once 'includes/head.php'; ?>
<?php $msg=filter_input(INPUT_GET, 'msg', FILTER_SANITIZE_STRING);?>


<body>
  <div class="container-fluid">
    <?php include_once 'includes/nav.php' ?>
    
    <div class="content">
      <?php include_once 'includes/header.php' ?>
      
      <main class="row">
        <div class="main-container"><?php $categoria=filter_input(INPUT_GET, 'categoria', FILTER_SANITIZE_STRING);?>
        <?php if ($msg == 'ok'){ echo '<p class="ok">Yay! Postcard successfully added!</p>'; } 
              else if ($msg == 'error'){ echo '<p class="error">Oh no! Something went wrong. Please try again!</p>'; }?>
          <h2>Add New Postcard</h2>
          
          <form class="add_form" action="formAdd.php" method="post" enctype="multipart/form-data">
            
            <div class="form-field col-md-6">
              <input type="text" id="description" name="description" placeholder="Description">
              <p class="error descriptionError hidden">Your postcard must have a description!</p>
            </div>
            
            <div class="form-field col-md-6">
              <select id="category" name="category">
                <option value="null">Choose a category</option>
                <?php foreach ($categories as $name=>$category ): ?>
                <option value="<?php echo $name ?>">
                  <?php echo $category?>
                </option>
                <?php endforeach; ?>
              </select>
              <p class="error categoryError hidden">Choose a category!</p>
            </div>
            
            <div class="form-field col-md-6">
              <input type="text" id="sender" name="sender" placeholder="Sender">
              <p class="error senderError hidden">The postcard must have a sender!</p>
            </div>
            
            <div class="form-field col-md-6">
              <select id="state" name="state">
                <option value="null">Choose a state</option>
                <?php foreach ($state as $name=>$state ): ?>
                <option value="<?php echo $name ?>">
                  <?php echo $state?>
                </option>
                <?php endforeach; ?>
              </select>
              <p class="error stateError hidden">Choose a state!</p>
            </div>
            
            <div class="form-field col-md-6">
              <input type="text" id="postcrossing_id" name="postcrossing_id" placeholder="Postcrossing ID">
            </div>
            
            <div class="form-field col-md-6">
              <select id="type" name="type">
                <option value="null">Choose a type</option>
                <?php foreach ($types as $name=>$type ): ?>
                <option value="<?php echo $name ?>">
                  <?php echo $type?>
                </option>
                <?php endforeach; ?>
              </select>
              <p class="error typeError hidden">Choose a type!</p>
            </div>
            
            <div class="form-field col-md-6">
              <label for="date">Date Received</label>
              <input type="date" id="date" name="date">
              <p class="error dateError hidden">Choose a date!</p>
            </div>
            
            <div class="form-field col-md-6">
              <select id="country" name="country">
                <option value="null">Choose a country</option>
                <?php foreach ($countries as $short=>$name ): ?>
                <option value="<?php echo $name ?>">
                  <?php echo $name?>
                </option>
                <?php endforeach; ?>
              </select>
              <p class="error countryError hidden">Choose a country!</p>
            </div>
            
            <div class="form-field col-md-6">
              <label for="photo">Image</label>
              <input type="file" id="photo" class="required" name="photo" value="">
              <p class="error photoError hidden">The image must be .png/.jpg/.jpeg!</p>
            </div>
            
            <div class="form-field col-md-6">
              <label class="favorite" for="photo">Favorite?</label>
              <input id="favorite" type="checkbox" name="favorite" value="1">
            </div>

            <div class="col-md-12 buttons">
              <input type="reset" value="Reset">
              <input type="submit" value="Send">
            </div>
            
          </form>
          
        </div>
      </main>
    </div>

  </div>
</body>
</html>
