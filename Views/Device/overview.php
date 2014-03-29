<!DOCTYPE html>
<html>
    <head>
        <title>EyeOrcas | Overview</title>
        <?php include ($_SERVER['DOCUMENT_ROOT'] . '/Layout/master.php');?>
        
    </head>
    <body class="overview aside aside-left">
        <div id="root">
            <?php include ($_SERVER['DOCUMENT_ROOT'] . '/Layout/header.php');?>
            <?php include ($_SERVER['DOCUMENT_ROOT'] . '/Layout/devicePanelSidebar.php');?>
            <section class="section-wrapper">
                    <h2>Overview</h2>
                    <section class="overview-section-content-wrapper">
                        <div class="overview-section-content-wrapper">
                            <ul class="list-inline">
                                <li id="deviceConnectedCount"></li>
                                <li id="deviceVideoCount"></li>
                                <li id="deviceLogCount"></li>
                            </ul>
                        </div>
                    </section>
            </section>
        </div>
        <script data-main="/js/device/overview.js" src="/cp-front/js/requireJs/require-jquery.js"></script>
        <script type="text/javascript">
            //variables
            var _currEntityId = "<?php echo $userHelper->getCurrentEntityId();?>";
	        var _currDeviceId = "<?php if(isset($deviceId)){echo $deviceId;}; ?>";
            var _currDeviceCode = "<?php if(isset($deviceCode)){echo $deviceCode;}; ?>";
            var _currDeviceName = "<?php if(isset($deviceName)){echo $deviceName;}; ?>";
            var _enterpriseId = "<?php echo $userHelper->getCurrentEnterpriseId(); ?>";
            var _apiHost  = "<?php echo $webConfig->cpApiHost; ?>";
        </script>
    </body>
</html>
