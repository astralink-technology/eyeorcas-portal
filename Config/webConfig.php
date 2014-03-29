<?php
/* Configuration File
 * Configuration parameters from enterprises can be retrieved from Astralink's DB for analytics purposes
 * Only a super admin at Astralink will be able to logon and retrieve enterprises' configurations
 * The enterprise configuration parameter will depend on which enterprise is chosen on the user's session
 * If a non super admin is logged on and no parameters is chosen, the database configuration file will remain as a normal config file
 */
class webConfig{
    public $production;          //production mode
    public $cpApiHost;          //chillipanda API mode

    public $enterpriseId;       //enterprise id given for the current web app
    public $enterpriseName;      //enterprise name given for the current web app

    public $mailHost;                //smtp host
    public $mailUsername;            //smtp username
    public $mailPassword;            //smtp API / password
    public $from;                //sending from which email address
    public $fromName;            //sender's name
    public $addReplyTo;          //reply path
    public $addReplyName;        //reply Recepient
    public $addCC;               //cc email
    public $addBCC;              //bcc email
    public $smtpSecure;          //'ssl' also accepted

    public $host; //db host
    public $port; //db port
    public $username; //db username
    public $password; //db password
    public $database; //db database stack


    public function productionConfig(){
        //set the main parameters over here
        $webConfig = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/Config/webConfig.ini', true);
        $this->production = $webConfig["mode"];
    }

    public function enterpriseConfig(){
        //set the main parameters over here
        $webConfig = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/Config/webConfig.ini', true);
        $productionVal = $webConfig["production"];
        $developmentVal = $webConfig["development"];
        $this->productionConfig();
        if ($this->production == true){
            $this->enterpriseId = $productionVal["enterpriseId"];
            $this->enterpriseName = $productionVal["enterpriseName"];
        }else{
            $this->enterpriseId = $developmentVal["enterpriseId"];
            $this->enterpriseName = $developmentVal["enterpriseName"];
        }
    }

    public function dbConfig(){
        //get the contents from the webConfig File
        $webConfig = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/Config/webConfig.ini', true);
        $productionVal = $webConfig["production"];
        $developmentVal = $webConfig["development"];
        $this->productionConfig();
        if ($this->production == true){
            $this->host = $productionVal["host"];
            $this->port = $productionVal["port"];
            $this->username = $productionVal["username"];
            $this->password = $productionVal["password"];
            $this->database = $productionVal["database"];
        }else{
            $this->host = $developmentVal["host"];
            $this->port = $developmentVal["port"];
            $this->username = $developmentVal["username"];
            $this->password = $developmentVal["password"];
            $this->database = $developmentVal["database"];
        }
    }

    public function cpApiConfig(){
        $webConfig = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/Config/webConfig.ini', true);
        $productionVal = $webConfig["production"];
        $developmentVal = $webConfig["development"];
        $this->productionConfig();
        if ($this->production == true){
            $this->cpApiHost = $productionVal["apiHost"];
        }else{
            $this->cpApiHost = $developmentVal["apiHost"];
        }
    }

    public function mailConfig(){
        $webConfig = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/Config/webConfig.ini', true);
        $productionVal = $webConfig["production"];
        $developmentVal = $webConfig["development"];
        $this->productionConfig();
        if ($this->production == true){
            $this->mailHost = $productionVal["mailHost"];
            $this->mailUsername = $productionVal["mailUsername"];
            $this->mailPassword = $productionVal["mailPassword"];
            $this->from = $productionVal["from"];
            $this->fromName = $productionVal["fromName"];
            $this->addReplyTo = $productionVal["addReplyTo"];
            $this->addReplyName = $productionVal["addReplyName"];
            $this->addBCC = $productionVal["addBCC"];
        }else{
            $this->mailHost = $developmentVal["mailHost"];
            $this->mailUsername = $developmentVal["mailUsername"];
            $this->mailPassword = $developmentVal["mailPassword"];
            $this->from = $developmentVal["from"];
            $this->fromName = $developmentVal["fromName"];
            $this->addReplyTo = $developmentVal["addReplyTo"];
            $this->addReplyName = $developmentVal["addReplyName"];
            $this->addBCC = $developmentVal["addBCC"];
        }
    }
}
?>
