<table class="table">
    <tr>
        <th></th>
        <th>ID</th>
        <th>Description</th>
        <th>Country</th>
        <th>Sender</th>
        <th>Postcrossing ID</th>
        <th>Category</th>
        <th>Type</th>
        <th>Date</th>
    </tr>
    <?php foreach ($postcard as $postcard): ?>
    <tr class="showPostcard" data-href="<?php echo site_url('postcard/'.$postcard['id']); ?>">
        <td class="not-mobile"><span class="edit glyphicon glyphicon-pencil"></span>
        </td>
        <td>
            <?php echo $postcard['id'] ?>
        </td>
        <td>
            <?php echo $postcard['description'] ?>
        </td>
        <td>
            <?php echo $postcard['country'] ?>
        </td>
        <td>
            <?php echo $postcard['sender'] ?>
        </td>
        <td>
            <?php if ($postcard['postcrossing_id']){ echo $postcard['postcrossing_id']; } else { echo "Not Official"; }?>
        </td>
        <td>
            <?php echo $postcard['category'] ?>
        </td>
        <td>
            <?php echo $postcard['type'] ?>
        </td>
        <td>
            <?php echo $postcard['date'] ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<div class="col-md-12 buttons">
    <button class="button back">Back</button>
</div>