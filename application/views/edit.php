<h2>Edit Postcard <?php echo $postcard->id ?></h2>
<?php if ($postcard): ?>
<form class="add-form" action="formUpdate.php" method="post" enctype="multipart/form-data">

    <div class="form-field col-md-6">
        <input type="text" id="description" name="description" placeholder="Description" value="<?php echo $postcard->description; ?>">
        <p class="error description-error hidden">The postcard must have a description!</p>
    </div>

    <div class="form-field col-md-6">
        <select id="category" name="category">
            <option value="null">Choose a Category</option>
            <?php foreach ($categories as $name=>$category ): ?>
            <option <?php if ($name==$postcard->category) echo "selected='selected'"; ?> value="
                <?php echo $name ?>">
                <?php echo $category?>
            </option>
            <?php endforeach; ?>
        </select>
        <p class="error category-error hidden">Choose a category!</p>
    </div>

    <div class="form-field col-md-6">
        <input type="text" id="sender" name="sender" placeholder="Sender" value="<?php echo $postcard->sender; ?>">
        <p class="error sender-error hidden">The postcard must have a sender!</p>
    </div>

    <div class="form-field col-md-6">
        <select id="state" name="state">
            <option value="null">Choose a State</option>
            <?php foreach ($state as $name=>$state ): ?>
            <option <?php if ($name==$postcard->state) echo "selected='selected'"; ?> value="
                <?php echo $name ?>">
                <?php echo $state?>
            </option>
            <?php endforeach; ?>
        </select>
        <p class="error state-error hidden">Choose a State!</p>
    </div>


    <div class="form-field col-md-6">
        <input type="text" id="postcrossing-id" name="postcrossing-id" placeholder="Postcrossing ID" <?php if($postcard->postcrossing-id !== null) echo "value='".$postcard->postcrossing-id."'"; ?>>
    </div>

    <div class="form-field col-md-6">
        <select id="type" name="type">
            <option value="null">Choose a Type</option>
            <?php foreach ($types as $name=>$type ): ?>
            <option <?php if ($name==$ postcard->type) echo "selected='selected'"; ?> value="
                <?php echo $name ?>">
                <?php echo $type ?>
            </option>
            <?php endforeach; ?>
        </select>
        <p class="error type-error hidden">Choose a type!</p>
    </div>

    <div class="form-field col-md-6">
        <label for="data">Date Received</label>
        <input value="<?php echo $postcard->date; ?>" type="date" id="date" name="date">
        <p class="error date-error hidden">Choose a date!</p>
    </div>

    <div class="form-field col-md-6">
        <select id="country" name="country">
            <option value="null">Choose a country</option>
            <?php foreach ($countries as $short=>$name ): ?>
            <option <?php if ($name==$ postcard->country) echo "selected='selected'"; ?> value="
                <?php echo $name ?>">
                <?php echo $name?>
            </option>
            <?php endforeach; ?>
        </select>
        <p class="error country-error hidden">Choose a country!</p>
    </div>

    <div class="form-field col-md-6">
        <label for="photo">Image</label>
        <input type="file" id="photo" name="photo" value="">
        <p class="error photo-error hidden">The image must be .png/.jpg/.jpeg!</p>
    </div>

    <div class="form-field col-md-6">
        <label class="favorite" for="photo">Favorite?</label>
        <input id="favorite" type="checkbox" name="favorite" value="1" checked="<?php if ($postcard->favorite == 1) echo 'true'; ?>">
    </div>

    <input class="hidden" type="text" name="id" value="<?php echo $postcard->id ?>">

    <div class="col-md-12 buttons">
        <input type="reset" value="Reset">
        <input type="submit" value="Send">
    </div>

</form>

<?php else: ?>
<p>Oh No! The postcard ID is invalid!</p>
<?php endif; ?>
