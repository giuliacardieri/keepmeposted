<?php $title="Categories" ; ?>
<?php include_once 'globals.php'; ?>
<?php include_once 'includes/head.php'; ?>

<body>
  <div class="container-fluid">
    <?php include_once 'includes/nav.php' ?>
    
    <div class="content">
      <?php include_once 'includes/header.php' ?>
      <main class="row">
        <div class="main-container">
          <h2>Categories</h2>
          
          <?php foreach ($categories as $option=>$category): ?>
          <button class="category" data-href="<?php echo 'show_category.php?category=' . $option ?>">
            <span class="glyphicon glyphicon-tag"></span>
            <?php echo $category ?>
            <span class="glyphicon glyphicon-chevron-right"></span>
          </button>
          <?php endforeach; ?>
          
          <div class="col-md-12 buttons">
            <button class="button back">Back</button>
          </div>
          
        </div>
      </main>
    </div>
  </div>
</body>

