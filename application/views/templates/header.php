<div class="row">
    <header class="col-xs-12 col-sm-12 col-md-12">
        <div class="row">
            <button type="button" id="menu-btn" class="menu-icon menu-hidden hidden">
                <span>&#9776;</span>
            </button>
            <h1 class="col-md-9"><a href="<?php echo site_url('home'); ?>">Keep Me Posted<img class="logo" src="<?php echo asset_url('images/logo-small.png'); ?>" alt="Keep Me Posted Logo" /></a></h1>
            <div class="col-md-3">
                <div class="col-md-10 search-field-wrapper">
                  <form class="search-form" role="search" method="post" action="<?php echo site_url('search/results'); ?>">
                      <input type="text" name="search" id="search-field" placeholder="Search">
                      <span class="search-btn glyphicon glyphicon-search"></span>
                  </form>
                </div>
                <div class="col-md-2 header-img-wrapper">
                    <img src="<?php echo asset_url('users/' . $photo ); ?>" alt="<?php echo $username; ?>'s photo" />
                </div>
            </div>
        </div>
    </header>
</div>
<div class="row">
    <div class="user-info hidden">
        <ul>
            <li><a href="<?php echo site_url('profile'); ?>">Profile</a></li>
            <li><a href="<?php echo site_url('settings'); ?>">Settings</a></li>
            <li><a href="<?php echo site_url('logout'); ?>">Logout</a></li>
        </ul>
    </div>
</div>
