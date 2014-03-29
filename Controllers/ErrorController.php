<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/view_helper.php');

class ErrorController
{
    public function index(){
        //default action here
    }
    
    public function missing(){
        $view = new cp_view_helper();
        echo $view->render($_SERVER['DOCUMENT_ROOT'] . '/Views/Error/missing.php', null);
    }
    
    public function illegal(){
        $view = new cp_view_helper();
        echo $view->render($_SERVER['DOCUMENT_ROOT'] . '/Views/Error/illegal.php', null);
    }
    
    public function invalid(){
        $view = new cp_view_helper();
        echo $view->render($_SERVER['DOCUMENT_ROOT'] . '/Views/Error/invalid.php', array(
            "message" => "Your request is invalid"
        ));
    }
    
}
?>