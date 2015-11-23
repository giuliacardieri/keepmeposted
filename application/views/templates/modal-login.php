<div class="modal fade" id="startModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Sign Up</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal signup-form" method="post" action="login/signup" data-parsley-validate>
                        <div class="form-group">
                            <div class="col-lg-12">
                                <label class="fname label-signup" for="fname">First Name</label>
                                <input class="error-tooltip" data-toggle="tooltip" data-placement="right" title="First Name" type="text" name="fname" id="fname" placeholder="First Name" data-parsley-ui-enabled="false" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-12">
                                <label class="lname label-signup" for="lname">Last Name</label>
                                <input class="error-tooltip" data-toggle="tooltip" data-placement="right" title="Last Name" type="text" name="lname" id="lname" placeholder="Last Name" data-parsley-ui-enabled="false" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-12">
                                <label class="username label-signup" for="username">Username</label>
                                <input class="error-tooltip" data-toggle="tooltip" data-placement="right" title="Username" type="text" name="username" id="username" placeholder="Username" data-parsley-ui-enabled="false" required data-parsley-length="[6, 20]">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-12">
                                <label class="email label-signup" for="email">Email</label>
                                <input class="error-tooltip" data-toggle="tooltip" data-placement="right" title="Email" type="email" name="email" id="email" placeholder="Email" data-parsley-ui-enabled="false" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-12">
                                <div class="select-fake">
                                    <label class="country label-signup" for="country">Country</label>
                                    <select class="error-tooltip" data-toggle="tooltip" data-placement="right" title="Country" id="country" name="country" data-parsley-ui-enabled="false" required>
                                        <option value="">Country</option>
                                        <?php foreach ($countries as $country): ?>
                                        <option value="<?php echo $country['id']; ?>">
                                            <?php echo $country['name']; ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-12">
                                <label class="password label-signup" for="password">Password</label>
                                <input class="error-tooltip" data-toggle="tooltip" data-placement="right" title="Password" type="password" name="password" id="password" placeholder="Password" data-parsley-ui-enabled="false" data-parsley-length="[8, 50]" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="signup-btn btn btn-primary">Send</button>
                </div>
            </div>
        </div>
    </div>

    
    
    <div class="modal fade" id="loginModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Login</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal login-form" action="login/login" method="post" data-parsley-validate>
                        <div class="form-group">
                            <div class="col-lg-12">
                                <label class="username_login label-signup" for="username">Username</label>
                                <input class="error-tooltip" data-toggle="tooltip" data-placement="right" title="" type="text" name="username" id="username_login" placeholder="Username" data-parsley-ui-enabled="false" required data-parsley-length="[6, 20]">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-12">
                                <label class="password_login label-signup" for="password">Password</label>
                                <input class="error-tooltip" data-toggle="tooltip" data-placement="right" title="" type="password" name="password" id="password_login" placeholder="Password" data-parsley-ui-enabled="false" data-parsley-length="[8, 50]" required>
                            </div>
                        </div>
                        <!--<p>Forgot your password?</p>-->
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit "class="btn btn-primary login-btn">Send</button>
                </div>
            </div>
        </div>
    </div>