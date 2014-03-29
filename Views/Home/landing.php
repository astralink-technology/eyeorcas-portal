<!DOCTYPE html>
<html>
    <head>
        <title>EyeOrcas | Connected. Anywhere, Everwhere.</title>
        <?php include ($_SERVER['DOCUMENT_ROOT'] . '/Layout/master.php');?>
    </head>
    <body class="landing">
        <div id="root">
            <section class="jumbotron">
                <header class="landing-header">
                    <ul class="list-inline public-controls">
                        <li><a class="btn btn-lg btn-link" href="/account/login">Log In</a></li>
                        <li><a class="btn btn-lg btn-primary" href="/account/signup">Sign Up</a></li>
                    </ul>
                </header>
                <div class="introduction">
                    <img src="/img/logo-landing.png" />
                    <h2 class="col-md-12">Get connected with things around you</h2>
                    <h4 class="col-md-12">Cloud application for internet of things</h4>
                    <div class="landing-illustration">
                        <span class="col-md-3 col-md-offset-2 multi-sensor"><img src="/img/multisensor-landing.png" /></span>
                        <span class="col-md-2 wifi"><img src="/img/wifi-landing.png" /></span>
                        <span class="col-md-3 iphone"><img src="/img/iphone-landing.png" /></span>
                    </div>
                </div>
            </section>
            <section class="how-it-works">
                <section class="col-md-10 col-md-offset-1">
                    <section class="how-it-work-steps col-md-4 connect">
                        <span class="img-wrapper"><img src="/img/connect.png" /></span>
                        <h3>Connect</h3>
                        <p>Install and connect eyeOrcas compatible devices to internet</p>
                    </section>
                    <section class="how-it-work-steps col-md-4 trigger">
                        <span class="img-wrapper"><img src="/img/trigger.png" /></span>
                        <h3>Trigger</h3>
                        <p>Triggered devices broadcast notifications to eyeOrcas Cloud</p>
                    </section>
                    <section class="how-it-work-steps col-md-4 notify">
                        <span class="img-wrapper"><img src="/img/alert.png" /></span>
                        <h3>Alert</h3>
                        <p>eyeOrcas receives notifications and option to view or control</p>
                    </section>
                </section>
            </section>
            <section class="landing-content">
                <div class="col-md-2 col-md-offset-2 img-wrapper">
                    <img src="/img/device-management.png" />
                </div>
                <div class="col-md-6 device-management">
                    <h2>Device Management</h2>
                    <p>View your device activities throughout the day event if you are away.
                        Control and view devices from device listings from eyeOrcas smartphone
                        App available from the App Store and Google Play</p>
                </div>
            </section>
            <section class="landing-content">
                <div>
                    <div class="col-md-5 col-md-offset-2">
                        <h2>Push Notifications, SMS and Email Alerts</h2>
                        <p>Receive device updates and triggered messages in forms of
                            Push Notifications, SMS and email alerts.</p>
                        <button class="btn btn-primary btn-lg">Register for Notifications</button>
                    </div>
                </div>
                <div>
                    <div  class="col-md-4 col-md-offset-6 img-wrapper">
                        <img src="/img/push-notify-multisensor.png" />
                    </div>
                </div>
        </div>
        </section>
        <section class="landing-content img-wrapper">
            <div class="col-md-2 col-md-offset-2 img-wrapper">
                <img src="/img/real-time.png" />
            </div>
            <div class="col-md-6 real-time">
                <h2>Real-time Access</h2>
                <p>Stream surveillance videos directly from connected cameras, energy
                    usage from connected appliances and temperature readings
                    from thermostats</p>
            </div>
        </section>
        <section class="landing-content img-wrapper">
            <div>
                <div class="col-md-5 col-md-offset-2">
                    <h2>Multi Platform</h2>
                    <p>eyeOrcas is not only iPhone and Android Applications.
                        Access eyeOrcas from any broswers from a laptop
                        or a desktop. </p>
                </div>
            </div>
            <div>
                <div  class="col-md-4 col-md-offset-6 img-wrapper">
                    <img src="/img/multiplatform.png" />
                </div>
            </div>
        </section>
        <section class="get-started">
            <h4>Ready to get connected with things?</h4>
            <button class="btn btn-lg btn-primary">Get Started</button>
        </section>
        <?php include ($_SERVER['DOCUMENT_ROOT'] . '/Layout/footer.php');?>
    </body>
</html>
