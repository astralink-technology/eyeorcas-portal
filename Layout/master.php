<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . ('/Helpers/session_helper.php');
    require_once $_SERVER['DOCUMENT_ROOT'] . ('/Helpers/authorization_helper.php');
    require_once $_SERVER['DOCUMENT_ROOT'] . ('/Helpers/user_helper.php');
    require_once $_SERVER['DOCUMENT_ROOT'] . ('/Helpers/productRegistration_helper.php');
    require_once $_SERVER['DOCUMENT_ROOT'] . '/Config/webConfig.php';

    $userHelper = new cp_user_helper();
    $productRegistrationHelper = new cp_productRegistration_helper();

    $webConfig = new webConfig();
    $webConfig->dbConfig();
    $webConfig->cpApiConfig();
    $webConfig->mailConfig();
    $webConfig->productionConfig();
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

<!-- bootstrap -->
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css">
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

<?php if ($webConfig->production == false){ ?>
    <link href="/css/compiled/site-p2p.css" rel="stylesheet" />
    <link href="/cp-front/css/compiled/cp-front-custom.css" rel="stylesheet" />
<?php }else{ ?>
    <link href="/css/compiled/site-p2p.min.css" rel="stylesheet" />
    <link href="/cp-front/css/compiled/cp-front-custom.min.css" rel="stylesheet" />
<?php } ?>

<script type="text/javascript" src="/cp-front/js/jquery-1.9.1/jquery.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/cp-front/js/kendo/js/kendo.web.min.js"></script>

<link rel="icon" href="/img/astraico.ico" type="image/x-icon" />


<link href='http://fonts.googleapis.com/css?family=Roboto:400,400italic,500,500italic,700,700italic,900,900italic,100,100italic,300,300italic' rel='stylesheet' type='text/css'>

<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]></script>
<script type="text/javascript" src="/cp-front/js/html5shiv.js"></script>
<style>
    /*html5*/

    figure {
        display: block;
        margin:  1em 40px;
    }
</style>
<![endif]-->
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-49818325-1', 'eyeorcas.com');
    ga('send', 'pageview');

</script>
