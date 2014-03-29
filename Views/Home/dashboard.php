<!DOCTYPE html>
<html>
    <head>
        <title>Orcas Eye | Dashboard</title>
        <?php include ($_SERVER['DOCUMENT_ROOT'] . '/Layout/master.php');?>
        <script type="text/javascript" src="/js/dashboard.js"></script>
        
        <script type="text/javascript" src="http://cp-core/cp-front/js/kendo/js/kendo.dataviz.min.js"></script>
        <link href="http://cp-core/cp-front/js/kendo/styles/kendo.dataviz.default.min.css" rel="stylesheet" />
    
    </head>
    <body class="dashboard">
        <?php include ($_SERVER['DOCUMENT_ROOT'] . '/P2P/Layout/sidebar.php');?>
        <div id="root">
            <?php include ($_SERVER['DOCUMENT_ROOT'] . '/P2P/Layout/header.php');?>
            <section class="sub-header pull-left">
                <h2><i class="icon icon-dashboard"></i><span>Dashboard</span></h2>
            </section>
            <section class="dashboard-content usage">
                <h3><i class="icon icon-bolt"></i> <span>Usage</span></h3>
                <div class="gauge">
                    <div id="sms-gauge"></div>
                    <h4>SMS</h4>
                    <div class="usage-details"><span>125</span> <span class="unit-label">Used</span></div>
                    <div class="usage-details"><span>325</span> <span class="unit-label">Left</span></div>
                </div>
                <div class="gauge">
                    <div id="storage-gauge"></div>
                    <h4>Storage</h4>
                    <div class="usage-details"><span>37</span> <span class="unit-label">GB Used</span></div>
                    <div class="usage-details"><span>3</span> <span class="unit-label">GB Left</span></div>
                </div>
                <div class="gauge">
                    <div id="push-gauge"></div>
                    <h4>Push Notification</h4>
                    <div class="usage-details"><span>200</span> <span class="unit-label">Used</span></div>
                    <div class="usage-details"><span>200</span> <span class="unit-label">Left</span></div>
                </div>
            </section>
            <section class="dashboard-content devices-connected">
                <h3><i class="icon icon-camera-retro"></i> <span>Camera Listing</span></h3>
                
                <div class="device">
                    <div class="media">
                    <a class="pull-left" href="#">
                      <img class="media-object">
                    </a>
                    <div class="media-body">
                      <h4 class="media-heading">Outdoor Camera</h4>
                      <div class="camera-model">CAM0001</div>
                      <div class="device-controls pull-right"><button class="btn btn-default btn-small">Remove</button></div>
                    </div>
                  </div>
                </div>
            </section>
            <section class="dashboard-content camera-listing">
                <h3><i class="icon icon-eye-open"></i> <span>Viewing Devices</span></h3>
                <div class="device">
                    <div class="media">
                    <a class="pull-left" href="#">
                        <div class="media-object"><i class="icon icon-apple"></i></div>
                    </a>
                    <div class="media-body">
                      <h4 class="media-heading">iPhone 5</h4>
                      <div class="phone-name">Shi Wei Eamon</div>
                      <div class="phone-model">C37K8206CTWD</div>
                    </div>
                  </div>
                </div>
                
                <div class="device">
                    <div class="media">
                    <a class="pull-left" href="#">
                        <div class="media-object"><i class="icon icon-apple"></i></div>
                    </a>
                    <div class="media-body">
                      <h4 class="media-heading">iPhone 5S</h4>
                      <div class="phone-name">Cety Lim</div>
                      <div class="phone-model">C37K8206CTWD</div>
                    </div>
                  </div>
                </div>
                
                <div class="device">
                    <div class="media">
                    <a class="pull-left" href="#">
                        <div class="media-object"><i class="icon icon-android"></i></div>
                    </a>
                    <div class="media-body">
                      <h4 class="media-heading">HTC One</h4>
                      <div class="phone-name">Chin Tiong</div>
                      <div class="phone-model">C37K8206CTWD</div>
                    </div>
                  </div>
                </div>
                
                <div class="device">
                    <div class="media">
                    <a class="pull-left" href="#">
                        <div class="media-object"><i class="icon icon-windows"></i></div>
                    </a>
                    <div class="media-body">
                      <h4 class="media-heading">Nokia Lumia</h4>
                      <div class="phone-name">Shi Wei</div>
                      <div class="phone-model">C37K8206CTWD</div>
                    </div>
                  </div>
                </div>
                
                <div class="device">
                    <div class="media">
                    <a class="pull-left" href="#">
                        <div class="media-object"><i class="icon icon-windows"></i></div>
                    </a>
                    <div class="media-body">
                      <h4 class="media-heading">Asus</h4>
                      <div class="phone-name">Shi Wei</div>
                      <div class="phone-model">C37K8206CTWD</div>
                    </div>
                  </div>
                </div>
                
                <div class="device">
                    <div class="media">
                    <a class="pull-left" href="#">
                        <div class="media-object"><i class="icon icon-linux"></i></div>
                    </a>
                    <div class="media-body">
                      <h4 class="media-heading">Ubuntu</h4>
                      <div class="phone-name">Cety Lim</div>
                      <div class="phone-model">C37K8206CTWD</div>
                    </div>
                  </div>
                </div>
                
            </section>
        </div>
        <?php include ($_SERVER['DOCUMENT_ROOT'] . '/Layout/footer.php');?>
    </body>
</html>
