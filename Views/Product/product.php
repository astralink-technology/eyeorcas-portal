<!DOCTYPE html>
<html>
<head>
    <title>EyeOrcas |EyeOrcas Product</title>
    <?php include ($_SERVER['DOCUMENT_ROOT'] . '/Layout/master.php');?>
</head>
<body class="my-devices aside aside-left">
<div id="root">
    <?php include ($_SERVER['DOCUMENT_ROOT'] . '/Layout/header.php');?>
    <aside>
        <div class="logo"><a href="/devices"><img src="/img/logo.png" /></a></div>
        <div class="home-panel">
            <ul class="list-unstyled">
                <li class="active"><a href="javascript:void(0)">EyeOrcas Products</a></li>
                <li><a href="/devices">Device Listing</a></li>
            </ul>
        </div>
    </aside>
    <section class="section-wrapper">
        <h2>EyeOrcas Products</h2>
    </section>
</div>

<script data-main="/js/profile/product.js" src="/cp-front/js/requireJs/require-jquery.js"></script>
<script type="text/javascript">
    //variables
    var _currEntityId = "<?php echo $userHelper->getCurrentEntityId();?>";
    var _enterpriseId = "<?php echo $userHelper->getCurrentEnterpriseId(); ?>";
    var _apiHost  = "<?php echo $webConfig->cpApiHost; ?>";
</script>
</body>
</html>
