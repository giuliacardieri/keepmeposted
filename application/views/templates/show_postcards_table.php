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
        <th class="not-mobile">Favorite</th>
    </tr>
    <?php foreach ($postcard as $postcard): ?>
    <tr class="showPostcard" data-href="<?php echo site_url('postcard/'.$postcard['id']); ?>">
        <td class="not-mobile"><span class="edit glyphicon glyphicon-pencil"></span>
        </td>
        <td>
            <?php echo $postcard[ 'id'] ?>
        </td>
        <td class="not-mobile">
            <?php echo $postcard[ 'description'] ?>
        </td>
        <td>
            <?php echo $postcard[ 'country'] ?>
        </td>
        <td>
            <?php echo $postcard[ 'sender'] ?>
        </td>
        <td class="not-mobile">
            <?php if ($postcard[ 'postcrossing_id']){ echo $postcard[ 'postcrossing_id']; } else { echo "Not Official"; }?>
        </td>
        <td>
            <?php echo $postcard[ 'category'] ?>
        </td>
        <td class="not-mobile">
            <?php echo $postcard[ 'type'] ?>
        </td>
        <td class="not-mobile">
            <?php echo $postcard[ 'date'] ?>
        </td>
        <td class="not-mobile">
            <?php if ($postcard[ 'favorite']==1 ) echo 'Yes'; else echo 'No'; ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<div class="col-md-12 buttons">
    <button class="button back">Back</button>
</div>