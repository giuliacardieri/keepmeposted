<div class="content">
    <?php if (!is_null($error)): ?>
        <div class="row">
            <div class="col-md-12">
                <p><?php echo $error; ?></p>
            </div>
        </div>
    <?php endif; ?>
    <div class="row">
        <header class="index col-md-9 col-sm-9 col-xs-11">
            <div class="row">
                <h1 class="col-md-6 col-sm-6 col-xs-8"><a href="#">Keep Me Posted<img class="logo" src="<?php echo asset_url('images/logo-small.png'); ?>" alt="Keep Me Posted Logo" /></a></h1>
                <div class="col-md-6 col-sm-6 col-xs-4 btn-wrapper-login">
                    <button class="button" data-toggle="modal" data-target="#loginModal">Login</button>
                </div>
            </div>
        </header>
    </div>

    <div class="row">
        <div class="photo-main">
            <div class="color-overlay"></div>
            <div class="text-container">
                <p>The easiest way to manage your postcard collection</p>
                <button class="button start" data-toggle="modal" data-target="#startModal">Get Started!</button>
            </div>
        </div>
    </div>
    <div class="row">
        <main class="index col-lg-8 col-md-8 col-sm-10 col-xs-10 col-lg-offset-2 col-md-offset-2 col-sm-offset-1 col-xs-offset-1">
            <div class="row">
                <div class="col-md-12">
                    <h2>What Is This?</h2>
                </div>
            </div>
            <div class="row what-section">
                <div class="col-lg-push-7 col-lg-5 col-md-push-7 col-md-5 col-sm-push-7 col-sm-5">
                    <img class="img-responsive" src="<?php echo asset_url('images/organize.png'); ?>" alt="organize illustration" />
                </div>
                <div class="col-lg-pull-5 col-lg-7 col-md-pull-5 col-md-7 col-sm-pull-5 col-sm-7 col-what-section">
                    <div class="text-what-section">
                        <h3>Organize your collection</h3>
                        <p>Keep Me Posted allows you to organize your postcards using categories and tags.</p>
                    </div>
                </div>
            </div>

            <div class="row what-section">
                <div class="col-lg-5 col-md-5 col-sm-5">
                    <img class="img-responsive" src="<?php echo asset_url('images/search.png'); ?>" alt="search illustration" />
                </div>
                <div class="col-lg-7 col-md-7 col-sm-7 col-what-section">
                    <div class="text-what-section">
                        <h3>Find postcards you like</h3>
                        <p>Check recommendations or use the search tool to find your new favourite postcards!</p>
                    </div>
                </div>
            </div>

            <div class="row what-section">
                <div class="col-lg-push-7 col-lg-5 col-md-push-7 col-md-5 col-sm-push-7 col-sm-5">
                    <img class="img-responsive" src="<?php echo asset_url('images/share.png'); ?>" alt="share illustration" />
                </div>
                <div class="col-lg-pull-5 col-lg-7 col-md-pull-5 col-md-7 col-sm-pull-5 col-sm-7 col-what-section">
                    <div class="text-what-section">
                        <h3>Share your collection</h3>
                        <p>Let your friends know about your awesome postcards using Facebook or Twitter.</p>
                    </div>
                </div>
            </div>

        </main>
    </div>
</div>

</div>
</body>
</html>
