<!DOCTYPE html>
<html>
    <head>
        <title>EyeOrcas | Connecting you through the cloud</title>
        <?php include ($_SERVER['DOCUMENT_ROOT'] . '/Layout/master.php');?>
    </head>
    <body class="set-password">
        <div id="root">
            <section class="section-wrapper">
                <div class="forgot-password-form-wrapper">
                    <div class="logo"><a href="/"><img src="/img/eyeOrcasLogo.png" /></a></div>
                    <h1>Set Password</h1>
                    <p>Create your secured password!</p>
                    <div class="signup-form">
                        <div class="alert alert-main" id="signup-error" style="display:none;"></div>
                        <div class="full-block">
                            <label>Password</label>
                            <input type="password" id="tb-new-password" />
                            <div class="alert alert-danger alert-sm" id="val-newPassword" style="display:none"></div>
                        </div>
                        <div class="full-block">
                            <label>Confirm Password</label>
                            <input type="password" id="tb-confirm-password" />
                            <div class="alert alert-danger alert-sm" id="val-confirmPassword" style="display:none"></div>
                        </div>
                        <div class="full-block">
                            <button id="btn-setpassword" class="btn btn-large btn-primary pull-right">Set Password</button>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div id="modalAjaxLoader"></div>
    </body>
    <script type="text/javascript">
        var _authId = "<?php echo $_GET['auth'];?>";
        var _enterpriseId = "<?php echo $userHelper->getCurrentEnterpriseId(); ?>";
    </script>
    <script data-main="/js/account/setPassword.js" src="/cp-front/js/requireJs/require-jquery.js"></script>
</html>
