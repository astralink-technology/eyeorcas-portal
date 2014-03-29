<?php
           
class cp_Authentication{
    public $authenticationId;
    public $authenticationString;
    public $authenticationStringLower;
    public $hash;
    public $salt;
    public $lastLogin;
    public $lastLogout;
    public $lastChangePassword;
    public $createDate;
    public $lastUpdate;
    public $requestAuthenticationStart;
    public $requestAuthenticationEnd;
    public $authorizationLevel;
    public $totalRows;

     public function __construct()  
    {  
    } 
}
?>
