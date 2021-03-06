<!DOCTYPE html>
<html>
    <head>
        <title>EyeOrcas | My Devices</title>
        <?php include ($_SERVER['DOCUMENT_ROOT'] . '/Layout/master-requirejs.php');?>
    </head>
    <body class="my-devices">
        <div id="root">
            <?php include ($_SERVER['DOCUMENT_ROOT'] . '/Layout/header.php');?>
            <h1 class="col-md-12">Dashboard</h1>
            <section class="col-md-12 my-devices-section usage-section">
                <h2>My Usage</h2>
                <div>
                    <ul class="list-inline">
                        <li id="pushUsage"></li>
                        <li id="smsUsage"></li>
                        <li id="storageUsage"></li>
                    </ul>
                </div>
            </section>
            <section class="col-md-12 my-devices-section device-listing-section">
                <h2>Device Listing</h2>
                <p>Get started by adding a device (i.e. HXS), or select an existing device</p>
                <div class="device-listing" id="device-listing"></div>
            </section>
            <div id="register-product"></div>
        </div>
        <?php include ($_SERVER['DOCUMENT_ROOT'] . '/Layout/footer.php');?>
        <script data-main="/js/device/myDevices.js" src="/cp-front/js/requireJs/require-jquery.js"></script>
        <script type="text/javascript">
            //variables
            var _currEntityId = "<?php echo $userHelper->getCurrentEntityId();?>";
            var _currProductId = "<?php echo $productRegistrationHelper->getUserRegisteredProductId();?>";
            var _enterpriseId = "<?php echo $userHelper->getCurrentEnterpriseId(); ?>";
            var _apiHost  = "<?php echo $webConfig->cpApiHost; ?>";
        </script>
    </body>
</html>
