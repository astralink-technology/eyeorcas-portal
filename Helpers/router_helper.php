<?php

/*
 * The master file that does all the routing methods
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/Helpers/view_helper.php';

class cp_router_helper{
    
    private $uriController = array(); //uri 
    private $uriActions = array();
    private $controllers = array();
    private $actions = array();
    
    /**
     * Build a collection of internal URI to look for
     * @param type $uri
     */
    public function add($uriController, $controller, $uriAction = null, $action = null){
        $this->uriController[] = $uriController;
        $this->uriActions[] = $uriAction;
        $this->controllers[] = $controller;
        if ($action == null){
            $this->actions[] = $action;
        }else{
            $this->actions[] = null;
        }
    }
    
    /**
     * When uri is submitted, the router checks if valid 
     */
    public function submit($indexUrl, $notFoundUrl){
        $controller = "";
        $action = "";
            
        if (isset($_GET['controller'])){
            $controller = $_GET['controller'];
        }
        if (isset($_GET['action'])){
            $action = $_GET['action'];
        }
        
        if ($controller == ""){ //if there are no controller specify, there is an error
            header( 'Location: ' . $indexUrl);
        }else{
            $i = 0;
            $len = count($this->uriController);
            foreach($this->uriController as $key => $value)
            {
                if (preg_match("#^$value$#", $controller))
                { 
                    //match the controller
                    if ($action != ""){
                        $extUriAction = $this->uriActions[$key];
                        if (preg_match("#^$extUriAction$#", $action))
                        {
                            if ($this->actions[$key] == null){ //users are using the action passed from the url
                                call_user_func(array($this->controllers[$key], $action));
                                break;
                            }else{ //users are using the action assigned
                                call_user_func(array($this->controllers[$key], $this->actions[$key]));
                                break;
                            }
                        }else{
                            if ($i == $len - 1){
                                header( 'Location: ' . $notFoundUrl);
                            }
                        }
                    }else{
                        call_user_func(array($this->controllers[$key], 'index'));
                        break;
                    }
                }else{
                    if ($i == $len - 1){
                        header( 'Location:' . $notFoundUrl);
                    }
                }
                $i++;
            }
        
        }
        
        
    }
}
?>

