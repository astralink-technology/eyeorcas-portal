<?php
/*
 * Authentication Controller
 */

require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/UTCconvertor_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/databaseAdapter_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/idgenerator_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/sqlconnection_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Classes/AuthenticationClass.php');

class cp_authentication_dao{
    public function createAuthentication(
            $authentication_string = null
            , $authentication_string_lower = null
            , $hash = null
            , $salt = null
            , $enterpriseId = null
            ){
       
        $idgeneratorhelper = new cp_idGenerator_helper();
        $authentication_id = $idgeneratorhelper->generateId();
	$utcHelper = new cp_UTCconvertor_helper();
        $createDate = $utcHelper->getCurrentDateTime();
        
        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $enterpriseId); // if nothing is passed in, it will return a connection string
        
        $res = pg_query_params($connectionString, 
            "SELECT add_authentication(
                $1 
                , $2
                , $3
                , $4
                , $5
                , $6
                , $7
                , $8
                , $9
                , $10
                , $11
                , $12
                , $13
            )", 
                array(
                $authentication_id 
                , $authentication_string
                , $authentication_string_lower
                , $hash
                , $salt 
                , null
                , null
                , null
                , null
                , null
                , null
                , $createDate
                , null
                )
                );
        
        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $authentication_id);
        
        //free up the buffer memory
	pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();
        
        //returns the data
        return $retData;
    }
    
    public function getAuthentication(
            $authenticationId
            , $authenticationStringLower = null
            , $pPageSize = null
            , $pSkipSize = null
            , $pEnterpriseId = null
            ){
                $sqlconnecthelper = new cp_sqlConnection_helper();
                $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string
        
	            $res = pg_query_params($connectionString,
                "SELECT * FROM get_authentication(
                    $1 
                    , $2
                    , $3
                    , $4
                )"
                , array(
                    $authenticationId
                    , $authenticationStringLower
                    , $pPageSize
                    , $pSkipSize
                ));
        $data = array();
	$rows = pg_fetch_all($res);
        
        for($r = 0; $r < count($rows); $r++){
                $row = $rows[$r];
                $authenticationClass = new cp_Authentication();
                $authenticationClass->authenticationId = $row["authentication_id"];
                $authenticationClass->authenticationString = $row["authentication_string"];
                $authenticationClass->authenticationStringLower = $row["authentication_string_lower"];
                $authenticationClass->hash = $row["hash"];
                $authenticationClass->salt = $row["salt"];
                $authenticationClass->lastLogin = $row["last_login"];
                $authenticationClass->lastLogout = $row["last_logout"];
                $authenticationClass->lastChangePassword = $row["last_change_password"];
                $authenticationClass->createDate = $row["create_date"];
                $authenticationClass->lastUpdate = $row["last_update"];
                $authenticationClass->requestAuthenticationStart = $row["request_authentication_start"];
                $authenticationClass->requestAuthenticationEnd = $row["request_authentication_end"];
                $authenticationClass->authorizationLevel = $row["authorization_level"];
                $authenticationClass->totalRows = $row["total_rows"];
                //add row to table
                array_push($data, $authenticationClass);
        }

        $rowsRet = pg_num_rows($res);
        $dataAdapter = new cp_databaseAdapter_helper();
        $retData = $dataAdapter->retDataResponse($res, $data, $rowsRet);
	    $sqlconnecthelper->dbDisconnect();
        return $retData;
    }

    public function updateAuthentication(
            $pAuthentication_id
            , $pAuthenticationString = null
            , $pAuthenticationStringLower = null
            , $pHash = null
            , $pSalt = null
            , $pLastLogin = null
            , $pLastLogout = null
            , $pLastChangePassword = null
            , $pLastUpdate = null
            , $pRequestAuthenticationStart = null
            , $pRequestAuthenticationEnd = null
            , $pAuthorizationLevel = null
            , $pEnterpriseId = null
            ){

        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string
        $res = pg_query_params($connectionString,
                "SELECT * FROM update_authentication(
                    $1 
                    , $2
                    , $3
                    , $4
                    , $5
                    , $6
                    , $7
                    , $8
                    , $9
                    , $10
                    , $11
                    , $12
                )"
                , array(
                    $pAuthentication_id
                    , $pAuthenticationString
                    , $pAuthenticationStringLower
                    , $pHash
                    , $pSalt
                    , $pLastLogin
                    , $pLastLogout
                    , $pLastChangePassword
                    , $pRequestAuthenticationStart
                    , $pRequestAuthenticationEnd
                    , $pAuthorizationLevel
                    , $pLastUpdate
                    ));
        
        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $pAuthentication_id);
        
        //free up the buffer memory
	pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();
        
        //returns the data
        return $retData;
    }

    public function deleteAuthentication(
            $authentication_id
            , $pEnterpriseId = null
            ){
	$sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string
        $res = pg_query_params($connectionString, 
            "SELECT * FROM delete_authentication(
                $1
            )"
            , array(
                $authentication_id
            ));
        
        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $authentication_id);
        
        //free up the buffer memory
	pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();
        
        //returns the data
        return $retData;
    }
}
 
?>
