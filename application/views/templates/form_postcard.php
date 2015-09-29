<div class="row">
    <form class="add-form" action="formAdd.php" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="form-field col-md-12">
                <label class="description-label" for="description">Description</label>
                <input type="text" id="description" name="description">
                <p class="error description-error hidden">Description can't be blank</p>
            </div>
        </div>

        <div class="row">
            <div class="form-field col-md-6">
                <label class="photo-label" for="photo">Image</label>
                <input type="file" id="photo" class="required" name="photo" value="">
                <p class="error photo-error hidden">.png/.jpg/.jpeg</p>
            </div>

            <div class="form-field col-md-6">
                <select id="country" name="country">
                    <option value="null">Choose a country</option>
                    <?php foreach ($countries as $short=>$name ): ?>
                    <option value="<?php echo $name ?>">
                        <?php echo $name?>
                    </option>
                    <?php endforeach; ?>
                </select>
                <p class="error country-error hidden">Choose a country</p>
            </div>
        </div>
        <div class="row received-field">
            <div class="form-field col-md-6">
                <label class="sender-label" for="sender">Sender</label>
                <input type="text" id="sender" name="sender">
                <p class="error sender-error hidden">Sender can't be blank</p>
            </div>
            <div class="form-field col-md-6">
                <label class="date-label" for="date">Date received</label>
                <input type="date" id="date" name="date">
                <p class="error date-error hidden">mm/dd/yyyy</p>
            </div>
        </div>
        <div class="row">
            <div class="form-field col-md-6">
                <select id="state" name="state">
                    <option value="null">Choose a state</option>
                    <?php foreach ($states as $name=>$state ): ?>
                    <option value="<?php echo $name ?>">
                        <?php echo $state?>
                    </option>
                    <?php endforeach; ?>
                </select>
                <p class="error state-error hidden">State can't be blank</p>
            </div>
            <div class="form-field col-md-6">
                <select id="category" name="category">
                    <option value="null">Choose a category</option>
                    <?php foreach ($categories as $name=>$category ): ?>
                    <option value="<?php echo $name ?>">
                        <?php echo $category?>
                    </option>
                    <?php endforeach; ?>
                </select>
                <p class="error category-error hidden">Category can't be blank</p>
            </div>
        </div>
        <div class="row received-field">
            <div class="form-field col-md-6">
                <label class="postcrossing-id-label" for="postcrossing-id">Postcrossing ID</label>
                <input type="text" id="postcrossing-id" name="postcrossing-id">
            </div>
            <div class="form-field col-md-6">
                <select id="type" name="type">
                    <option value="null">Choose a swap type</option>
                    <?php foreach ($types as $name=>$type ): ?>
                    <option value="<?php echo $name ?>">
                        <?php echo $type?>
                    </option>
                    <?php endforeach; ?>
                </select>
                <p class="error type-error hidden">Swap type can't be blank</p>
            </div>

        </div>
        <div class="row hidden swap">
            <div class="form-field col-md-6">
                <label class="available" for="available">Is available?</label>
                <input id="available" type="checkbox" name="available" value="1">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 button-wrapper">
                <input type="reset" value="Reset">
                <input type="submit" value="Send">
            </div>
        </div>
    </form>
</div>