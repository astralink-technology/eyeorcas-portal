<!DOCTYPE html>
<html>
    <head>
        <title>EyeOrcas | Gallery</title>
        <?php include ($_SERVER['DOCUMENT_ROOT'] . '/Layout/master-requirejs.php');?>
        <!-- video JS -->
        <link href="//vjs.zencdn.net/4.2/video-js.css" rel="stylesheet">
        <script src="//vjs.zencdn.net/4.2/video.js"></script>
    </head>
    <body class="gallery">
        <div id="root">
            <?php include ($_SERVER['DOCUMENT_ROOT'] . '/Layout/header.php');?>
            <?php
            if(isset($deviceId)){
                include ($_SERVER['DOCUMENT_ROOT'] . '/Layout/devicePanelSidebar.php');
            }else{
            }
            ?>
            <h1 class="col-md-12">Gallery</h1>
            <section class="col-md-12">
                <div id="video-gallery"></div>
            </section>
        </div>
        <script data-main="/js/media/gallery.js" src="/cp-front/js/requireJs/require-jquery.js"></script>
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
