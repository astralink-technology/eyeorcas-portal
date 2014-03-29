<!DOCTYPE html>
<html>
    <head>
        <title>EyeOrcas | Log In</title>
        <?php include ($_SERVER['DOCUMENT_ROOT'] . '/Layout/master.php');?>
    </head>
    <body class="login">
        <div id="root">
            <section class="section-wrapper">
                <div class="login-form-wrapper">
                    <div class="logo"><a href="/"><img src="/img/eyeOrcasLogo.png" /></a></div>
                    <div class="login-form">
                        <div class="alert alert-main" id="login-error" style="display:none;"></div>
                        <div class="full-block">
                            <label>Email</label>
                            <input id="tb-username" type="email" tabindex="1" />
                            <div class="alert alert-danger alert-sm" id="val-loginUsername" style="display:none"></div>
                        </div>
                        <div class="full-block">
                            <div class="label-group">
                                <label class="password-label">Password</label>
                                <label class="forgotpassword-label"><a href="/account/forgotPassword" tabindex="4">Forgot?</a></label>
                            </div>
                            <input id="tb-password" type="password"  tabindex="2"/>
                            <div class="alert alert-danger alert-sm" id="val-loginPassword" style="display:none"></div>
                        </div>
                        <div class="full-block">
                            <button class="btn btn-primary btn-login" id="btn-login" tabindex="3">Log in</button>
                        </div>
                        <div class="full-block">
                            <a href="/account/signup" class="btn btn-link btn-extra-links">New to eyeOrcas?</a>
                        </div>
                    </div>
                </div>
                <div id="modalAjaxLoader"></div>
            </section>
        </div>
    </body>
    <script data-main="/js/account/logIn.js" src="/cp-front/js/requireJs/require-jquery.js"></script>
</html>
