<option value="0">Choose a option</option>
<?php foreach ($filter_types as $key => $postcard_type): ?>
	<?php if (is_array($postcard_type)): ?>
		<option value="<?php echo $postcard_type['id']; ?>"><?php echo $postcard_type['name']; ?></option>
	<?php else: ?>
		<option value="<?php echo $key; ?>"><?php echo $postcard_type; ?></option>
	<?php endif; ?>
<?php endforeach; ?>
