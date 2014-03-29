<?php
/*
 * Copyright Chilli Panda
 * Created on 01-03-2013
 * Created by Shi Wei Eamon
 */

/*
 *  A helper to connect you to the database
 */

require_once $_SERVER['DOCUMENT_ROOT'] . '/Config/webConfig.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Helpers/user_helper.php';

class cp_sqlConnection_helper extends webConfig{

    public $enterpriseId;

    public $host;
    public $username;
    public $password;
    public $database;
    public $port;


    protected $connectionString = NULL;
    
    protected function initializeConnection(){
        $webConfig = new webConfig();
        $webConfig->dbConfig();
        $this->host = $webConfig->host;
        $this->port = $webConfig->port;
        $this->username = $webConfig->username;
        $this->password = $webConfig->password;
        $this->database = $webConfig->database;

        $webConfig->enterpriseConfig();
        $this->enterpriseId = $webConfig->enterpriseId;
    }

    function dbConnect(
            $returnConnectionString = true //returns the connection string, default is it true
            , $enterpriseId = NULL//connect to third party enterprise configuration
            , $feedback = NULL //visual feedback, returns a string
            , $extDb = NULL
            , $extHost = NULL
            , $extPort = NULL
            , $extUsername = NULL
            , $extPassword = NULL
            ){
        
        $this->initializeConnection();
        $currentDatabase = $this->database;
        $currentHost = $this->host;
        $currentPort = $this->port;
        $currentUsername = $this->username;
        $currentPassword = $this->password;

        $targetHost = null;
        $targetPort = null;
        $targetUsername = null;
        $targetDb = null;
        $targetPassword = null;

        //if user present with third party database, they are allowed to connect to the db
        if ($extDb != null && $extHost != null && $extPort != null && $extUsername != null && $extPassword != null){
            $this->connectionString = pg_connect("host=". $extHost ." port=". $extPort . " dbname=" . $extDb . " user=" . $extUsername . " password= " . $extPassword );
        }else{
            //match if we are going to query the current database
            $userHelper = new cp_user_helper();
            if ($enterpriseId != null){
                //query and get the configuration
                $tempConnectionString = pg_connect("host=". $currentHost ." port=". $currentPort . " dbname=" . $currentDatabase . " user=" . $currentUsername . " password= " . $currentPassword );
                $res = pg_query_params($tempConnectionString,
                    "SELECT * FROM get_configuration(
                        $1
                        , $2
                        , $3
                        , $4
                        , $5
                        , $6
                    )"
                    , array(
                        null
                    , null
                    , 'D' //database configuration type
                    , $enterpriseId
                    , null
                    , null
                    ));
                $data = array();
                $rows = pg_fetch_all($res);
                //get the first row (Should not have any duplicates)
                $row = $rows[0];
                $targetHost = $row["value"];
                $targetPort = $row["value2"];
                $targetUsername = $row["value3"];
                $targetDb = $row["value_hash"];
                $targetPassword = $row["value2_hash"];
                $this->connectionString = pg_connect("host=". $targetHost ." port=". $targetPort . " dbname=" . $targetDb ." user=". $targetUsername ." password= ". $targetPassword);
            }else{
                //if enterprise is not passed in, connect to the current database
                $this->connectionString = pg_connect("host=". $currentHost ." port=". $currentPort . " dbname=" . $currentDatabase . " user=". $currentUsername ." password= ". $currentPassword );
            }
        }

        if (!$this->connectionString) {
            die('Could not connect');
            if ($feedback != null or $feedback == true){
                echo 'Unable to connect';
            }
            if ($returnConnectionString == true){
                return null;
            }
        }else{
	
            if ($feedback != null or $feedback == true){
                echo 'Connected';
            }
            if ($returnConnectionString == true){
                return $this->connectionString; // by default, it will return a connection string.
            }
        }
    }
    
    function dbDisconnect(){
        pg_close($this->connectionString);
    }
}
?>
