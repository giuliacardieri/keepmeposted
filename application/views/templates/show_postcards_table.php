<div class="row">
  <table class="table">
    <tr>
        <th></th>
        <th>Description</th>
        <th>Sender</th>
        <th>Country</th>
        <th>Date</th>
        <th>Category</th>
        <th>Type</th>
        <th>State</th>
        <th>Postcrossing ID</th>
        <th>Is Swap?</th>
    </tr>
    <?php foreach ($postcard as $postcard): ?>
    <tr class="showPostcard" data-href="<?php echo site_url('postcard/'.$postcard['id']); ?>">
        <td class="not-mobile"><span class="edit glyphicon glyphicon-search"></span>
        </td>
        <td>
            <?php echo $postcard['description'] ?>
        </td>
        <td>
            <?php echo ($postcard['is_swap'] == 1) ? '-' : $postcard['sender'] ?>
        </td>
        <td>
            <?php echo $postcard['country_name'] ?>
        </td>
        <td>
            <?php echo ($postcard['is_swap'] == 1) ? '-' : $postcard['date_received'] ?>
        </td>
        <td>
            <?php echo $postcard['category'] ?>
        </td>
        <td>
            <?php echo ($postcard['is_swap'] == 1) ? '-' : $postcard['type'] ?>
        </td>
        <td>
            <?php echo ($postcard['is_swap'] == 1) ? '-' : $postcard['state'] ?>
        </td>
        <td>
            <?php if ($postcard['is_swap'] == 1) { echo '-'; } else if ($postcard['postcrossing_id']){ echo $postcard['postcrossing_id']; } else { echo "Not Official"; } ?>
        </td>
        <td>
            <?php echo ($postcard['is_swap'] == 1) ? 'Yes' : 'No'?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
</div>
<div class="row">
    <button class="button back">Back</button>
</div>
