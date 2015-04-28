<?php $title="Home" ; ?>
<?php include_once 'globals.php'; ?>
<?php include_once 'includes/head.php'; ?>

<body>
  <div class="container-fluid">
    <?php include_once 'includes/nav.php' ?>
    <div class="content">
      <button type="button" id="menu-btn" class="menu-icon menu-hidden">
        <span>&#9776;</span> 
      </button>


      <main class="row">
        <div class="photo-main">
          <div class="color-overlay"></div>
          <div class="text-container">
            <h1>Keep Me Posted<img class="logo" src="images/logo.png" alt="Keep Me Posted Logo" /></h1>
            <p>The easiest way to manage your postcard collection</p>
            <button class="button start" data-href="add.php">Get Started!</button>
          </div>
        </div>

        <div class="row main-container">
            <h2>How it works?</h2>
            <div class="col-md-4 element">
              <span class="icon-main glyphicon glyphicon-plus"></span>
              <p>First you go to memory lane (which is fun, trust me!) and add information and photos from all your postcards.</p>
            </div>
          
            <div class="col-md-4 element">
              <span class="icon-main glyphicon glyphicon-star"></span>
              <p>Don't forget to categorize and favorite them! And it's ok if most your postcards are your favorites, it's so hard to choose just a few!</p>
            </div>
          
            <div class="col-md-4 element">
              <span class="icon-main glyphicon glyphicon-globe"></span>
              <p>Great! Now you can show your collection to your friends or just keep it to yourself.</p>
            </div>
          
            <div class="col-md-4 element">
              <span class="icon-main glyphicon glyphicon-tags"></span>
              <p>Is your collection too big? That's fine, show it by category, just the favorites or a special one.</p>
            </div>
          
            <div class="col-md-4 element">
              <span class="icon-main glyphicon glyphicon-search"></span>
              <p>Need help? Search your collection by one of the fields and find the card you want in a few clicks!</p>
          </div>
        </div>
      </main>  
    </div>
  </div>



</body>

</html>
