<!DOCTYPE html>
<html>
    <head>
        <title>EyeOrcas | 404 Not Found</title>
        <?php include ($_SERVER['DOCUMENT_ROOT'] . '/Layout/master.php');?>
    </head>
    <body class="missing">
        <div id="root">
            <?php include ($_SERVER['DOCUMENT_ROOT'] . '/Layout/header.php');?>
            <section>
                <h1><i class="fa fa-frown-o"></i> <br>Invalid Request!</h1>
                <p>Oops<?php if(isset($message)){echo ", " . $message;}; ?>. Return back <a href="<?php echo '/' ?>"> home</a></p>
            </section>
        </div>
    </body>
</html>
