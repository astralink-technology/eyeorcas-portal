<!DOCTYPE html>
<html>
    <head>
        <title>EyeOrcas | Sign Up</title>
        <?php include ($_SERVER['DOCUMENT_ROOT'] . '/Layout/master.php');?>
    </head>
    <body class="signup">
        <div id="root">
            <section class="section-wrapper">
                <div class="signup-form-wrapper">
                    <div class="logo"><a href="/"><img src="/img/eyeOrcasLogo.png" /></a></div>
                    <h1>Get Started</h1>
                    <p>Sign Up for a starter account today!</p>
                    <div class="signup-form">
                        <div class="alert alert-main" id="signup-error" style="display:none;"></div>
                        <div class="full-block">
                            <label>Given Name</label>
                            <input id="tb-given-name" type="text" />
                            <div class="alert alert-danger alert-sm" id="val-givenName" style="display:none"></div>
                        </div>
                        <div class="full-block">
                            <label>Last Name</label>
                            <input id="tb-first-name" type="text" />
                            <div class="alert alert-danger alert-sm" id="val-firstName" style="display:none"></div>
                        </div>
                        <div class="full-block">
                            <label>Email</label>
                            <input id="tb-email" type="email" />
                            <div class="alert alert-danger alert-sm" id="val-email" style="display:none"></div>
                        </div>
                        <div class="full-block">
                            <button class="btn btn-primary btn-signup" id="btn-signup">Sign up</button>
                        </div>
                        <div class="full-block">
                            <a href="/account/login" class="btn btn-link btn-extra-links">Already have an account?</a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div id="modalAjaxLoader"></div>
    </body>
    <script data-main="/js/account/signUp.js" src="/cp-front/js/requireJs/require-jquery.js"></script>
</html>