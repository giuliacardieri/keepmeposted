<div class="row">
    <nav class="col-xs-hidden col-sm-hidden col-md-2">
        <ul class="nav nav-pills nav-stacked">
            <li>
                <a <?php if ($active == 'home') echo "class='active'"; ?> href="<?php echo site_url('home'); ?>">
                    <span class="glyphicon glyphicon-home"></span>
                    <span class="not-mobile">Home</span>
                </a>
            </li>
            <li>
                <a <?php if ($active == 'add') echo "class='active'"; ?> href="<?php echo site_url('postcard/add'); ?>">
                    <span class="glyphicon glyphicon-plus"></span>
                    <span class="not-mobile">Add</span>
                </a>
            </li>
            <li>
                <a <?php if ($active == 'collection') echo "class='active'"; ?> href="<?php echo site_url('collection'); ?>">
                    <span class="glyphicon glyphicon-th"></span>
                    <span class="not-mobile">Collection</span>
                </a>
            </li>
            <li>
                <a <?php if ($active == 'favorites') echo "class='active'"; ?> href="<?php echo site_url('favorites'); ?>">
                    <span class="glyphicon glyphicon-star"></span>
                    <span class="not-mobile">Favorites</span>
                </a>
            </li>
            <li>
                <a <?php if ($active == 'history') echo "class='active'"; ?> href="<?php echo site_url('history'); ?>">
                    <span class="glyphicon glyphicon-th-list"></span>
                    <span class="not-mobile">History</span>
                </a>
            </li>
            <li>
                <a <?php if ($active == 'profile') echo "class='active'"; ?> href="<?php echo site_url('profile'); ?>">
                    <span class="glyphicon glyphicon-user"></span>
                    <span class="not-mobile">Profile</span>
                </a>
            </li>
            <li>
                <a <?php if ($active == 'swap') echo "class='active'"; ?> href="<?php echo site_url('swap'); ?>">
                    <span class="glyphicon glyphicon-send"></span>
                    <span class="not-mobile">Swap</span>
                </a>
            </li>
        </ul>
    </nav>
    <div class="main col-md-10 col-md-10 col-md-offset-2 col-lg-offset-2 ">
