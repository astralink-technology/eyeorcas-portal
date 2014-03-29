<!DOCTYPE html>
<html>
    <head>
        <title>EyeOrcas | Update Password</title>
        <?php include ($_SERVER['DOCUMENT_ROOT'] . '/Layout/master.php');?>
    </head>
    <body class="password-old">
        <div id="root">
            <section class="section-wrapper">
                <div class="password-old-form-wrapper">
                    <div class="logo"><a href="/"><img src="/P2P/img/eyeOrcasLogo.png" /></a></div>
                    <h1>Update your password</h1>
                    <p>EyeOrcas has updated its security, change your password to make your account more secured.</p>
                    <div class="password-old-form">
                        <div class="alert alert-main" id="oldpassword-error" style="display:none;"></div>
                        <div class="full-block">
                            <label>Current Password</label>
                            <input id="tb-old-password" type="password" />
                            <div class="alert alert-danger alert-sm" id="val-oldPassword" style="display:none"></div>
                        </div>
                        <div class="full-block">
                            <label>New Password</label>
                            <input id="tb-new-password" type="password" />
                            <div class="alert alert-danger alert-sm" id="val-newPassword" style="display:none"></div>
                        </div>
                        <div class="full-block">
                            <label>Confirm Password</label>
                            <input id="tb-confirm-password" type="password" />
                            <div class="alert alert-danger alert-sm" id="val-confirmPassword" style="display:none"></div>
                        </div>
                        <div class="full-block controls">
                            <button class="btn btn-primary btn-update" id="btn-update-password">Update</button>
                        </div>
                    </div>
            </section>
        </div>
        <div id="modalAjaxLoader"></div>
    </body>
    <script type="text/javascript">
        var _authId = "<?php echo $_GET['auth'];?>";
	    var _OS = "<?php echo $_GET['OS'];?>";
        var _enterpriseId = "<?php echo $userHelper->getCurrentEnterpriseId(); ?>";
    </script>
    <script data-main="/js/account/passwordOld.js" src="/cp-front/js/requireJs/require-jquery.js"></script>
</html>
