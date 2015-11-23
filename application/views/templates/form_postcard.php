<div class="row">
    <form class="add-form" action="<?php echo site_url('postcard/insert_postcard'); ?>" method="post" enctype="multipart/form-data" data-parsley-validate>
        <div class="row">
            <div class="form-field col-md-12">
                <label class="description-label" for="description">Description</label>
                <input type="text" id="description" name="description" data-parsley-required="true" data-parsley-length="[10, 250]" data-parsley-errors-container=".description">
                <p class="description field-error hidden"></p>
            </div>
        </div>

        <div class="row">
            <div class="form-field col-md-6">
                <label class="photo-label" for="photo">Image</label>
                <input type="file" id="photo" name="photo" value="" data-parsley-errors-container=".photo">
                <p class="photo field-error hidden">.png/.jpg/.jpeg</p>
            </div>

            <div class="form-field col-md-6">
                <select id="country" name="country" data-parsley-errors-container=".country" data-parsley-required="true">
                    <option value="">Choose a country</option>
                    <?php foreach ($countries as $country ): ?>
                    <option value="<?php echo $country['id'] ?>">
                        <?php echo $country['name'] ?>
                    </option>
                    <?php endforeach; ?>
                </select>
                <p class="field-error country hidden"></p>
            </div>
        </div>
        <div class="row received-field">
            <div class="form-field col-md-6">
                <label class="sender-label" for="sender">Sender</label>
                <input type="text" id="sender" class="received-attr" name="sender" data-parsley-errors-container=".sender" data-parsley-required="true">
                <p class="field-error sender hidden"></p>
            </div>
            <div class="form-field col-md-6">
                <label class="datepicker-add-label" for="date">Date received</label>
                <input type="text" id="datepicker-add" class="received-attr" name="date" data-parsley-errors-container=".date" data-parsley-required="true">
                <p class="field-error date hidden"></p>
            </div>
        </div>
        <div class="row">
            <div class="form-field col-md-6 received-field">
                <select id="state" class="received-attr" name="state" data-parsley-errors-container=".state" data-parsley-required="true">
                    <option value="">Choose a state</option>
                    <?php foreach ($states as $name=>$state ): ?>
                    <option value="<?php echo $state?>">
                        <?php echo $state?>
                    </option>
                    <?php endforeach; ?>
                </select>
                <p class="field-error state hidden"></p>
            </div>
            <div class="form-field col-md-6 hidden swap-field">
                <select id="available" name="available" data-parsley-errors-container=".available" data-parsley-required="true">
                    <option value="1">Available</option>
                    <option value="0">Not available</option>
                </select>
                <p class="field-error available hidden"></p>
            </div>
            <div class="form-field col-md-6">
                <select id="category" name="category" data-parsley-errors-container=".category" data-parsley-required="true">
                    <option value="">Choose a category</option>
                    <?php foreach ($categories as $categories): ?>
                    <option value="<?php echo $categories['id'] ?>">
                        <?php echo $categories['name']?>
                    </option>
                    <?php endforeach; ?>
                </select>
                <p class="field-error category hidden"></p>
            </div>
        </div>
        <div class="row received-field">
            <div class="form-field col-md-6">
                <label class="postcrossing-id-label" for="postcrossing-id">Postcrossing ID</label>
                <input type="text" id="postcrossing-id" name="postcrossing-id" data-parsley-errors-container=".postcrossing-id" data-parsley-pattern="[A-Z]{2}[-]\d{1,8}" data-parsley-error-message="Valid format: ID-1234">
                <p class="field-error postcrossing-id hidden"></p>
            </div>
            <div class="form-field col-md-6">
                <select id="type" name="type" class="received-attr" data-parsley-errors-container=".type" data-parsley-required="true">
                    <option value="">Choose a swap type</option>
                    <?php foreach ($types as $name=>$type ): ?>
                    <option value="<?php echo $type ?>">
                        <?php echo $type?>
                    </option>
                    <?php endforeach; ?>
                </select>
                <p class="field-error type hidden"></p>
            </div>
        </div>
        <div class="row">
          <div class="form-field tags-wrapper col-md-12">
              <label class="new-chip-label" for="new-chip">Tags</label>
              <div class="chip-wrapper postcard-chip"></div>
              <div class="new-chip">
                <input type="text" id="new-chip" class="postcard-chip" name="new-chip" data-parsley-errors-container=".new-tag">
                <button class="button btn-add-chip">Add</button>
              </div>
              <p class="chip-helper hidden">+ Add tag</p>
              <p class="new-tag field-error hidden"></p>
          </div>
        </div>

        <input id="swap" type="hidden" name="swap" value="0">
        <input id="tags-value" type="hidden" name="tags-value" value="">

        <div class="row">
            <div class="col-md-12 button-wrapper">
                <input type="reset" value="Reset">
                <input name="submit2" class="add-submit" type="submit" value="Send">
            </div>
        </div>
    </form>
</div>
