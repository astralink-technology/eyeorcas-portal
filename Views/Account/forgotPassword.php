<!DOCTYPE html>
<html>
    <head>
        <title>EyeOrcas | Forgot Password</title>
        <?php include ($_SERVER['DOCUMENT_ROOT'] . '/Layout/master.php');?>
    </head>
    <body class="forgot-password">
        <div id="root">
            <section class="section-wrapper">
                <div class="forgot-password-form-wrapper">
                    <div class="logo"><a href="/P2P"><img src="/P2P/img/eyeOrcasLogo.png" /></a></div>
                    <h1>Forgot Password</h1>
                    <p>Bummer! Request for a new password with your registered email.</p>
                    <form class="forgot-password-form">
                        <div class="full-block">
                            <label>Email</label>
                            <input id="tb-email" type="email" />
                        </div>
                        <div class="full-block controls">
                            <button class="btn btn-primary btn-request">Request</button>
                        </div>
                        <div class="full-block">
                            <a href="/account/signup" class="btn btn-link btn-extra-links">New to eyeOrcas?</a>
                        </div>
                        <div class="full-block">
                            <a href="/account/login" class="btn btn-link btn-extra-links">I remembered!</a>
                        </div>
                    </form>
            </section>
        </div>
    </body>
</html>
