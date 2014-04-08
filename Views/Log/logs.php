<!DOCTYPE html>
<html>
    <head>
        <title>EyeOrcas | Activities</title>
        <?php include ($_SERVER['DOCUMENT_ROOT'] . '/Layout/master-requirejs.php');?>
    </head>
    <body class="logs aside aside-left">
        <div id="root">
            <?php include ($_SERVER['DOCUMENT_ROOT'] . '/Layout/header.php');?>
            <?php
                if(isset($deviceId)){
                    include ($_SERVER['DOCUMENT_ROOT'] . '/Layout/devicePanelSidebar.php');
                }else{
                }
            ?>
            <h1 class="col-md-12">Activities</h1>
            <section id="log-listing" class="col-md-10">
                <div class="logListings" id="activity-listings"></div>
            </section>
            <section id="log-filters" class="col-md-2">
                <div id="activity-filters"></div>
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
