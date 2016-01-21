<div class="row">
    <header class="col-xs-12 col-sm-12 col-md-12">
        <div class="row">
            <button class="menu-icon hidden-md hidden-lg" type="button" id="menu-btn">
                <span class="menu-btn-span">&#9776;</span>
                <span class="glyphicon glyphicon-chevron-left hidden"></span>
            </button>
            <h1 class="col-xs-10 col-sm-10 col-md-9 main-header"><a href="<?php echo site_url('home'); ?>">Keep Me Posted<img class="logo" src="<?php echo asset_url('images/logo-small.png'); ?>" alt="Keep Me Posted Logo" /></a></h1>
            <div class="col-xs-10 col-sm-10 hidden-md hidden-lg search-field-mobile hidden">
                <form class="search-form-mobile" role="search" method="post" action="<?php echo site_url('search/search'); ?>">
                  <input type="text" name="search" id="search-field-mobile" placeholder="Search" data-parsley-type="alphanum" required>
                </form>
            </div>
            <div class="col-xs-2 col-sm-2 col-md-3">
                <div class="row">
                    <div class="hidden-xs hidden-sm col-md-10 search-field-wrapper">
                      <form class="search-form" role="search" method="post" action="<?php echo site_url('search/search'); ?>">
                          <input type="text" name="search" id="search-field" placeholder="Search" data-parsley-type="alphanum" required>
                          <span class="search-btn glyphicon glyphicon-search"></span>
                      </form>
                    </div>
                    <div class="hidden-xs hidden-sm col-md-2 header-img-wrapper">
                        <img src="<?php echo asset_url('users/' . $photo ); ?>" alt="<?php echo $username; ?>'s photo" />
                    </div>
                    <div class="col-xs-11 col-xs-offset-1 col-sm-5 col-sm-offset-7 hidden-md hidden-lg search-btn-mobile">
                          <span class="search-btn-mobile glyphicon glyphicon-search"></span>
                    </div>
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
