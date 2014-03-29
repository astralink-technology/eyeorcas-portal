<?php
include_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/router_helper.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/Controllers/AccountController.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/Controllers/DeviceController.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/Controllers/LogController.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/Controllers/MediaController.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/Controllers/ProductController.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/Controllers/HomeController.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/Controllers/ErrorController.php');

$accountController = new AccountController();
$homeController = new HomeController();
$deviceController = new DeviceController();
$logController = new LogController();
$mediaController = new MediaController();
$productController = new ProductController();
$errorController = new ErrorController();

$router = new cp_router_helper();

//Home Controls
$router->add("home", $homeController, "dashboard");
$router->add("landing", $homeController, "landing");

//Error Controls
$router->add("error", $errorController , "illegal");
$router->add("error", $errorController , "missing");
$router->add("error", $errorController , "invalid");

//Account Controls 
$router->add("account", $accountController, "signup");
$router->add("account", $accountController, "passwordOld");
$router->add("account", $accountController, "passwordOldCheck");
$router->add("account", $accountController, "changePassword");
$router->add("account", $accountController, "settings");
$router->add("account", $accountController, "login");
$router->add("account", $accountController, "forgotPassword");
$router->add("account", $accountController, "retrievePassword");
$router->add("account", $accountController, "logout");
$router->add("account", $accountController, "loggedin");
$router->add("account", $accountController, "success");
$router->add("account", $accountController, "getEntity");
$router->add("account", $accountController, "appLogin");

/* FIX ME, MERGE SET PASSWORD WIT CREATE PASSWORD METHOD */
$router->add("account", $accountController, "setpassword");
$router->add("account", $accountController, "createPassword");

//Device Controls
$router->add("devices", $deviceController, "overview");
$router->add("devices", $deviceController, "settings");
$router->add("devices", $deviceController, "viewers");

//Media Controls
$router->add("media", $mediaController);

//Log Controls
$router->add("logs", $logController);

//Product Controls
$router->add("products", $productController);
$router->submit('/home', '/error/missing');

?>
