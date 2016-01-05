<div class="row">
  <table class="table">
    <tr>
        <th class="default" data-href="<?php echo site_url('history/reload_history/description'); ?>">Description<span class="glyphicon glyphicon-triangle-top"></span><span class="glyphicon glyphicon-triangle-bottom"></span></th>
        <th class="default" data-href="<?php echo site_url('history/reload_history/sender'); ?>">Sender<span class="glyphicon glyphicon-triangle-top"></span><span class="glyphicon glyphicon-triangle-bottom"></span></th>
        <th class="default" data-href="<?php echo site_url('history/reload_history/country'); ?>">Country<span class="glyphicon glyphicon-triangle-top"></span><span class="glyphicon glyphicon-triangle-bottom"></span></th>
        <th class="default" data-href="<?php echo site_url('history/reload_history/date_received'); ?>">Date<span class="glyphicon glyphicon-triangle-top"></span><span class="glyphicon glyphicon-triangle-bottom"></span></th>
        <th class="default" data-href="<?php echo site_url('history/reload_history/category'); ?>">Category<span class="glyphicon glyphicon-triangle-top"></span><span class="glyphicon glyphicon-triangle-bottom"></span></th>
        <th class="default" data-href="<?php echo site_url('history/reload_history/type'); ?>">Type<span class="glyphicon glyphicon-triangle-top"></span><span class="glyphicon glyphicon-triangle-bottom"></span></th>
        <th class="default" data-href="<?php echo site_url('history/reload_history/state'); ?>">State<span class="glyphicon glyphicon-triangle-top"></span><span class="glyphicon glyphicon-triangle-bottom"></span></th>
        <th class="default" data-href="<?php echo site_url('history/reload_history/postcrossing_id'); ?>">Postcrossing ID<span class="glyphicon glyphicon-triangle-top"></span><span class="glyphicon glyphicon-triangle-bottom"></span></th>
    </tr>
    <?php foreach ($postcard as $postcard): ?>
    <tr class="showPostcard" data-href="<?php echo site_url('postcard/'.$postcard['id']); ?>">
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
    </tr>
    <?php endforeach; ?>
</table>
</div>
