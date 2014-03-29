<!DOCTYPE html>
<html>
    <head>
        <title>Orcas Eye</title>
        <?php include ($_SERVER['DOCUMENT_ROOT'] . '/Layout/master.php');?>
        <script type="text/javascript" src="js/index.js"></script>
    </head>
    <body class="index">
        <div id="root">
            <h1>Orcas Eye</h1>
            <div class="form-wrapper">
                <div class="form content" id="login-form" >
                    <div class="alert alert-error alert-main" id="login-error" style="display:none;"></div>
                    <div class="full-block">
                        <label>Username</label>
                        <input type="text" id="tb-username"/>
                        <div class="alert alert-error" id="val-loginUsername" style="display:none"></div>
                    </div>
                    <div class="full-block">
                        <label>Password</label>
                        <input type="password" id="tb-password" />
                        <div class="alert alert-error" id="val-loginPassword" style="display:none"></div>
                    </div>
                    <div class="full-block">
                        <div class="login-controls">
                            <button id="bt-login" class="btn btn-large btn-primary pull-right">Log in</button>
                        </div>
                    </div>
                    <div class="full-block">
                        <div class="controls">
                            <button class="btn btn-link bt-newToP2P pull-right">New to Orcas Eye?</button>
                            <button id="bt-forgetPassword" class="btn btn-link pull-right">Forgot password?</button>
                        </div>
                    </div>
                </div>
                <div class="form content" id="signup-form" >
                    <div class="alert alert-error alert-main" id="signup-error" style="display:none;"></div>
                    <div class="full-block">
                        <label>Given Name</label>
                        <input type="text" id="GivenName"/>
                        <div class="alert alert-error" id="val-givenName" style="display:none"></div>
                    </div>
                    <div class="full-block">
                        <label>Family Name</label>
                        <input type="text" id="FamilyName"/>
                        <div class="alert alert-error" id="val-familyName" style="display:none"></div>
                    </div>
                    <div class="full-block">
                        <label>Email</label>
                        <input type="email" id="Email"/>
                        <div class="alert alert-error" id="val-email" style="display:none"></div>
                    </div>
                    <div class="full-block">
                        <div class="login-controls">
                            <button id="bt-signup" class="btn btn-large btn-primary pull-right">Sign Up</button>
                        </div>
                    </div>
                    <div class="full-block">
                        <div class="controls">
                            <button class="btn btn-link bt-haveAnAccount pull-right">Already have an account?</button>
                        </div>
                    </div>
                </div>
                <div class="form content" id="forgetpassword-form" >
                    <div class="alert alert-error alert-main" id="forgotpassword-error" style="display:none;"></div>
                    <div class="full-block">
                        <label>User Email</label>
                        <input type="email" id="tb-forgotPasswordEmail"/>
                        <div class="alert alert-error" id="val-forgotPasswordEmail" style="display:none"></div>
                    </div>
                    <div class="full-block">
                        <div class="login-controls">
                            <button id="bt-retrieve-credentials" class="btn btn-large btn-primary pull-right">Retrieve Credentials</button>
                        </div>
                    </div>
                    <div class="full-block">
                        <div class="controls">
                            <button class="btn btn-link bt-newToP2P pull-right">New to Orcas Eye?</button>
                            <button class="btn btn-link bt-haveAnAccount pull-right">Already have an account?</button>
                        </div>
                    </div>
                </div>
                <div class="confirmation-message content" id="password-requested-success" >
                    <h2>Email Sent!</h2>
                    <div class="full-block">
                        <div class="controls home-control">
                            <button class="btn bt-home btn-large btn-primary">Home</button>
                        </div>
                    </div>
                </div>
                <div class="confirmation-message content" id="signup-success" >
                    <h2>Sign Up Success!</h2>
                    <div class="full-block">
                        <div class="controls home-control">
                            <button class="btn bt-home btn-large btn-primary">Home</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include ($_SERVER['DOCUMENT_ROOT'] . '/Layout/footer.php');?>
    </body>
</html>
