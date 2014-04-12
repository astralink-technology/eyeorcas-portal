<!DOCTYPE html>
<html>
    <head>
        <title>EyeOrcas | Sign Up</title>
        <?php include ($_SERVER['DOCUMENT_ROOT'] . '/Layout/master.php');?>
    </head>
    <body class="signup">
        <div id="root">
                <div class="signup-form-wrapper">
                    <div role="form">
                        <div class="logo"><a href="/"><img src="/img/logo-md.png" /></a></div>
                        <h2>Get Started</h2>
                        <p>Sign Up for a starter account today!</p>
                        <div class="alert alert-main" id="signup-error" style="display:none;"></div>
                        <div class="form-group">
                            <label for="tb-given-name">Given Name</label>
                            <input id="tb-given-name" class="form-control" placeholder="Given Name" type="text" />
                            <div class="alert alert-danger alert-sm" id="val-givenName" style="display:none"></div>
                        </div>
                        <div class="form-group">
                            <label for="tb-first-name">Last Name</label>
                            <input id="tb-first-name" class="form-control" placeholder="Last Name" type="text" />
                            <div class="alert alert-danger alert-sm" id="val-firstName" style="display:none"></div>
                        </div>
                        <div class="form-group">
                            <label for="tb-email">Email</label>
                            <input id="tb-email" class="form-control" placeholder="Email" type="email" />
                            <div class="alert alert-danger alert-sm" id="val-email" style="display:none"></div>
                        </div>
                        <div class="form-group">
                            <label for="tb-password">Password</label>
                            <input id="tb-password" class="form-control" placeholder="Password" type="password" />
                            <div class="alert alert-danger alert-sm" id="val-password" style="display:none"></div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-signup" id="btn-signup">Sign up</button>
                        </div>
                        <div class="form-group">
                            <a href="/account/login" class="btn btn-link btn-extra-links">Already have an account?</a>
                        </div>
                    </div>
                </div>
        </div>
        <div id="modalAjaxLoader"></div>
    </body>
    <script data-main="/js/account/signUp.js" src="/cp-front/js/requireJs/require-jquery.js"></script>
</html>