<!DOCTYPE html>
<html>
<head>
    <title>EyeOrcas | Device Settings</title>
    <?php include ($_SERVER['DOCUMENT_ROOT'] . '/Layout/master.php');?>
</head>
<body class="device-settings aside aside-left">
<div id="root">
    <?php include ($_SERVER['DOCUMENT_ROOT'] . '/Layout/header.php');?>
    <?php include ($_SERVER['DOCUMENT_ROOT'] . '/Layout/devicePanelSidebar.php');?>
    <section class="section-wrapper">
        <h2>Device Settings</h2>
        <section class="sms-settings-section">
            <div class="sms-control-group">
                <h3><i class="fa fa-phone-square"></i> SMS Settings</h3>
                <span id="device-sms-notification-toggle"></span>
                <button id="btn-addPhone" class="btn btn-primary btn-phone-number"><i class="fa fa-plus"></i> Phone Number</button>
            </div>
            <div id="connected-phone-listing"></div>
            <div id="add-connected-phone"></div>
        </section>
    </section>
</div>
<script data-main="/js/device/deviceSettings.js" src="/cp-front/js/requireJs/require-jquery.js"></script>
<script type="text/javascript">
    //variables
    var _currEntityId = "<?php echo $userHelper->getCurrentEntityId();?>";
    var _currDeviceId = "<?php  if(isset($deviceId)){echo $deviceId;}; ?>";
    var _currDeviceName = "<?php  if(isset($deviceName)){echo $deviceName;}; ?>";
    var _enterpriseId = "<?php echo $userHelper->getCurrentEnterpriseId(); ?>";
    var _apiHost  = "<?php echo $webConfig->cpApiHost; ?>";
</script>
</body>
</html>
