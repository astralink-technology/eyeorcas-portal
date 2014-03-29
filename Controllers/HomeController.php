<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/view_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/authorization_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/user_helper.php');

class HomeController
{
    public function index(){
        $userHelper = new cp_user_helper();
        $entityId = $userHelper->getCurrentEntityId();
        if ($entityId != null){
            header( 'Location:/devices');
            return;
        }
        
        //default action here, this is a public page
        $view = new cp_view_helper();
        echo $view->render($_SERVER['DOCUMENT_ROOT'] . '/Views/Home/landing.php', array());
    }
    
    public function dashboard(){
        //only users are allowed;
        $authorizationHelper = new cp_authorization_helper();
        $authorizationHelper->setUserAuthorization("/home");
        
        $view = new cp_view_helper();
        echo $view->render($_SERVER['DOCUMENT_ROOT'] . '/Views/Home/dashboard.php', array());
    }
}
?>
