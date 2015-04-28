<?php $title="Search" ; ?>
<?php include_once 'globals.php'; ?>
<?php include_once 'includes/head.php'; ?>
<?php require_once 'classes/repository.php' ?>

<body>
  <div class="container-fluid">
    <?php include_once 'includes/nav.php' ?>
    <div class="content">
      <?php include_once 'includes/header.php' ?>
      <main class="row">
        <div class="main-container">
          <h2>Search a postcard</h2>
          
          <form class="search-form" action="result.php" method="post">
            
            <div class="col-md-6">
              <input type="text" id="search" name="search" placeholder="Search here">
              <p class="error searchError hidden">Type a keyword!</p>
            </div>
            
            <div class="col-md-6">
              <select id="field" name="field">
                <option value="null">Choose an attribute</option>
                <option value="id">ID</option>
                <option value="country">Country</option>
                <option value="description">Description</option>
                <option value="category">Category</option>
                <option value="sender">Sender</option>
                <option value="postcrossing_id">Postcrossing ID</option>
                <option value="type">Type</option>
                <option value="condition">Condition</option>
              </select>
              <p class="error fieldError hidden">Choose an attribute!</p>
            </div>

            <div class="col-md-12 buttons">
              <input class="search" type="submit" value="Search">
            </div>
            
          </form>
          
        </div>

      </main>
    </div>

  </div>



</body>

</html>
