<!DOCTYPE html>
<html>
    <head>
        <title>EyeOrcas | Activities</title>
        <?php include ($_SERVER['DOCUMENT_ROOT'] . '/Layout/master.php');?>
    </head>
    <body class="logs aside aside-left">
        <div id="root">
            <?php include ($_SERVER['DOCUMENT_ROOT'] . '/Layout/header.php');?>
            <?php
                if(isset($deviceId)){
                    include ($_SERVER['DOCUMENT_ROOT'] . '/Layout/devicePanelSidebar.php');
                }else{
                    include ($_SERVER['DOCUMENT_ROOT'] . '/Layout/defaultPanelSidebar.php');
                }
            ?>
            <section class="section-wrapper">
                <h2>Activities</h2>
                <section id="log-listing" class="pull-left">
                    <div class="logListings" id="activity-listings"></div>
                </section>
                <section id="log-filters" class="pull-right">
                    <div id="activity-filters"></div>
                </section>
            </section>
        </div>
        <script data-main="/js/log/logs.js" src="/cp-front/js/requireJs/require-jquery.js"></script>
        <script type="text/javascript">
            //variables
	    var _currDeviceId = "<?php if(isset($deviceId)){echo $deviceId;}; ?>";
        var _currEntityId = "<?php echo $userHelper->getCurrentEntityId();?>";
        var _enterpriseId = "<?php echo $userHelper->getCurrentEnterpriseId(); ?>";
        var _apiHost  = "<?php echo $webConfig->cpApiHost; ?>";
        </script>
    </body>
</html>
