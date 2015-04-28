<?php $title="Result"; ?>
<?php include_once 'globals.php'; ?>
<?php include_once 'includes/head.php'; ?>
<?php require_once 'classes/repository.php' ?>
<?php 
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $field = '';
    $value = '';
    $pdo_parameters = array();
    $field = trim($_POST['field']); 
    $value = trim($_POST['search']);
    if (!empty($field) && !empty($value))
      $search=repository::getPostcardSearch($field, $value);
}
?>

<body>
  <div class="container-fluid">
    <?php include_once 'includes/nav.php' ?>
    <div class="content">
      <?php include_once 'includes/header.php' ?>
      <main class="row">
        <div class="main-container">
          
          <h2>Search Results - <?php echo sizeof($search)." result(s)" ?></h2>
          <?php if ($search): ?>
          
          <table class="table">
            <tr>
              <th class="not-mobile"></th>
              <th>ID</th>
              <th class="not-mobile">Description</th>
              <th>Country</th>
              <th>Sender</th>
              <th class="not-mobile">Postcrossing ID</th>
              <th>Category</th>
              <th class="not-mobile">Type</th>
              <th class="not-mobile">Date</th>
            </tr>
          <?php foreach (repository::getPostcardSearch($field, $value) as $postcard): ?>
            <tr class="showPostcard" data-href="<?php echo 'postcard.php?id=' . $postcard->id ?>">
              <td class="not-mobile"><span class="edit glyphicon glyphicon-pencil"></span></td>
              <td><?php echo $postcard->id ?></td>
              <td class="not-mobile"><?php echo $postcard->description ?></td>
              <td><?php echo $postcard->country ?></td>
              <td><?php echo $postcard->sender ?></td>
              <td class="not-mobile"><?php if ($postcard->postcrossing_id){ echo $postcard->postcrossing_id; } else { echo "Not Official"; }?></td>
              <td><?php echo $categories[$postcard->category] ?></td> 
              <td class="not-mobile"><?php echo $types[$postcard->type] ?></td> 
              <td class="not-mobile"><?php echo $postcard->date ?></td> 
            </tr>
            <?php endforeach; ?>
          </table>
          
          <?php else: ?>
          <p>No postcard matches the criteria searched.</p>
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
