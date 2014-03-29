<!DOCTYPE html>
<html>
<head>
    <title>EyeOrcas | Change Password</title>
    <?php include ($_SERVER['DOCUMENT_ROOT'] . '/Layout/master.php');?>
</head>
<body class="my-devices aside aside-left">
<div id="root">
    <?php include ($_SERVER['DOCUMENT_ROOT'] . '/Layout/header.php');?>
    <aside>
        <div class="logo"><a href="/devices"><img src="/img/logo.png" /></a></div>
        <div class="home-panel">
            <ul class="list-unstyled">
                <li class="active"><a href="javascript:void(0)">Account Settings</a></li>
                <li><a href="/devices">Device Listing</a></li>
            </ul>
        </div>
    </aside>
    <section class="section-wrapper">
        <h2>Account Settings</h2>
        <section>
            <h3>Change Password</h3>
        </section>
        <div class="password-form">
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

<script data-main="/js/account/settings.js" src="/cp-front/js/requireJs/require-jquery.js"></script>
<script type="text/javascript">
    //variables
    var _currEntityId = "<?php echo $userHelper->getCurrentEntityId();?>";
    var _enterpriseId = "<?php echo $userHelper->getCurrentEnterpriseId(); ?>";
</script>
</body>
</html>
