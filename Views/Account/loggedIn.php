<!DOCTYPE html>
<html>
    <head>
        <title>EyeOrcas | Already Logged In</title>
        <?php include ($_SERVER['DOCUMENT_ROOT'] . '/Layout/master.php');?>
    </head>
    <body class="illegal">
        <div id="root">
            <?php include ($_SERVER['DOCUMENT_ROOT'] . '/Layout/header.php');?>
            <section>
                <h1><i class="fa fa-smile-o"></i> <br>Hello!</h1>
                <p>You are already logged in. Return to <a href="<?php echo '/' ?>">dashboard</a></p>
            </section>
        </div>
    </body>
</html>
