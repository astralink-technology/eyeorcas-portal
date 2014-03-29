<?php
header('Access-Control-Allow-Origin: *');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/view_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/authorization_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/user_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/UTCconvertor_helper.php');
class ProductController
{
    public function index(){
        //only users are allowed;
        $authorizationHelper = new cp_authorization_helper();
        $authorizationHelper->setUserAuthorization("/home");

        //render the page view
        $view = new cp_view_helper();
        echo $view->render($_SERVER['DOCUMENT_ROOT'] . '/Views/Product/product.php', array());
    }
}
?>
