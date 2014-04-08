<!DOCTYPE html>
<html>
    <head>
        <title>EyeOrcas | Log In</title>
        <?php include ($_SERVER['DOCUMENT_ROOT'] . '/Layout/master.php');?>
    </head>
    <body class="login">
        <div id="root">
            <div role="form" class="login-form-wrapper">
                <div class="logo"><a href="/"><img src="/img/logo-md.png" /></a></div>
                <h2>Log In</h2>
                <p>Access, Connect and Control</p>
                <div class="alert alert-main" id="login-error" style="display:none;"></div>
                <div class="form-group">
                    <label for="tb-username">Email</label>
                    <input id="tb-username" class="form-control" placeholder="Email" type="email" tabindex="1" />
                    <div class="alert alert-danger alert-sm" id="val-loginUsername" style="display:none"></div>
                </div>
                <div class="form-group">
                    <label class="password-label pull-left" for="tb-password">Password</label>
                    <label class="forgotpassword-label pull-right"><a href="/account/forgotPassword" tabindex="4">Forgot?</a></label>
                    <input id="tb-password" placeholder="Password" class="form-control" type="password"  tabindex="2"/>
                    <div class="alert alert-danger alert-sm" id="val-loginPassword" style="display:none"></div>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-login" id="btn-login" tabindex="3">Log in</button>
                </div>
                <div class="form-group">
                    <a href="/account/signup" class="btn btn-link btn-extra-links">New to eyeOrcas?</a>
                </div>
            </div>

                </div>
                <div id="modalAjaxLoader"></div>
        </div>
    </body>
    <script data-main="/js/account/logIn.js" src="/cp-front/js/requireJs/require-jquery.js"></script>
</html>
