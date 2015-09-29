<h2>Postcard <?php echo $postcard['id'] ?></h2>

<div class="postcard-container">

    <div class="img-container">
        <img class="postcard-img" src="data:image/jpeg;base64,<?php //echo base64_encode( $postcard['photo'] ); ?>" />
    </div>
    <div class="postcard-text-container">
        <h3><?php echo $postcard['description'] ?></h3>

        <p>Sent by <?php echo $postcard['sender'] . ' - ' . $postcard['country'] ?></p>
        <p> <?php echo $postcard['type'] . ' - ' . $postcard['state'] ?></p>

        <p>Date: <?php echo $postcard['date'] ?></p>

        <?php if ($postcard['postcrossing_id']): ?>
        <p>Postcrossing ID: <?php echo $postcard['postcrossing_id']; ?></p>
        <?php endif; ?>

        <?php if ($postcard['favorite'] == 1): ?>
        <div class="clicable fav">
            <span class="glyphicon glyphicon-star"></span>
            Favorite
        </div>
        <?php endif; ?>
    </div>
</div>

<div class="col-md-12 buttons">
    <button class="button back">Back</button>
    <button class="button remove" data-href="<?php echo $postcard['id'] ?>">Delete</button>
    <button class="button edit-btn" data-href="<?php echo $postcard['id'] ?>">Edit</button>
</div>
