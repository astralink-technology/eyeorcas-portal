<?php
/*
 * Entity Controller
 */

require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/UTCconvertor_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/databaseAdapter_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/idgenerator_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/sqlconnection_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Classes/EntityClass.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Classes/AdminEntityDetailClass.php');

class cp_entity_dao{
    public function createEntity(
            $pFirstName = null
            , $pLastName = null
	        , $pNickName = null
            , $pStatus = null
            , $pApproved = null
            , $pType = null
            , $pAuthenticationId = null
            , $pPrimaryEmailId = null
            , $pPrimaryPhoneId = null
            , $pEnterpriseId = null
            ){  
        
        $idgeneratorhelper = new cp_idGenerator_helper();
        $entityId = $idgeneratorhelper->generateId();
       
	$utcHelper = new cp_UTCconvertor_helper();
        $pCreateDate = $utcHelper->getCurrentDateTime();
        
        $pName = $pFirstName . " " . $pLastName;
        
        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string
        $res = pg_query_params($connectionString, 
            "SELECT * FROM add_entity (
            $1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, $13
            )"
            , array(
            $entityId
            , $pFirstName
            , $pLastName
            , $pNickName
            , $pName
            , $pStatus
            , $pApproved
            , $pType
            , $pCreateDate
            , null
            , $pAuthenticationId
            , $pPrimaryEmailId
            , $pPrimaryPhoneId
            ));
        
        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $entityId);
        
        //free up the buffer memory
	pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();
        
        //returns the data
        return $retData;
    }
    
    public function getEntity(
	        $pEntityId
            , $pAuthenticationId = null
            , $pPageSize = null
            , $pSkipSize = null
            , $pEnterpriseId = null
            ){

        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string

	$res = pg_query_params($connectionString,
                "SELECT * FROM get_entity(
                    $1 , $2, $3, $4
                )"
                , array(
                    $pEntityId
                    , $pAuthenticationId
                    , $pPageSize
                    , $pSkipSize
                ));
        $data = array();
	$rows = pg_fetch_all($res);

        for($r = 0; $r < count($rows); $r++){
                $row = $rows[$r];
                $entityClass = new cp_Entity();
                $entityClass->entityId = $row["entity_id"];
                $entityClass->firstName = $row["first_name"];
                $entityClass->lastName = $row["last_name"];
                $entityClass->nickName = $row["nick_name"];
                $entityClass->name = $row["name"];
                $entityClass->status = $row["status"];
                $entityClass->approved = $row["approved"];
                $entityClass->type = $row["type"];
                $entityClass->createDate = $row["create_date"];
                $entityClass->lastUpdate = $row["last_update"];
                $entityClass->authenticationId = $row["authentication_id"];
                $entityClass->primaryEmailId = $row["primary_email_id"];
                $entityClass->primaryPhoneId = $row["primary_phone_id"];
                $entityClass->totalRows = $row["total_rows"];

                //add row to table
                array_push($data, $entityClass);
        }

        $rowsRet = pg_num_rows($res);
        $dataAdapter = new cp_databaseAdapter_helper();
        $retData = $dataAdapter->retDataResponse($res, $data, $rowsRet);

	$sqlconnecthelper->dbDisconnect();
        return $retData;
        
    }

    public function getAdminEntityDetail(
        $pEntityId
        , $pAuthenticationId = null
        , $pPageSize = null
        , $pSkipSize = null
        , $pEnterpriseId = null
    ){

        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string

        $res = pg_query_params($connectionString,
            "SELECT * FROM get_admin_entity_detail(
                $1 , $2, $3, $4
            )"
            , array(
                $pEntityId
                , $pAuthenticationId
                , $pPageSize
                , $pSkipSize
            ));
        $data = array();
        $rows = pg_fetch_all($res);

        for($r = 0; $r < count($rows); $r++){
            $row = $rows[$r];
            $adminEntityClass = new cp_Admin_Entity_Detail();
            $adminEntityClass->entityId = $row["entity_id"];
            $adminEntityClass->firstName = $row["first_name"];
            $adminEntityClass->lastName = $row["last_name"];
            $adminEntityClass->nickName = $row["nick_name"];
            $adminEntityClass->name = $row["name"];
            $adminEntityClass->status = $row["status"];
            $adminEntityClass->approved = $row["approved"];
            $adminEntityClass->type = $row["type"];
            $adminEntityClass->createDate = $row["create_date"];
            $adminEntityClass->lastUpdate = $row["last_update"];
            $adminEntityClass->authenticationId = $row["authentication_id"];
            $adminEntityClass->primaryEmailId = $row["primary_email_id"];
            $adminEntityClass->primaryPhoneId = $row["primary_phone_id"];
            $adminEntityClass->authorizationLevel = $row["authorization_level"];
            $adminEntityClass->lastLogin = $row["last_login"];
            $adminEntityClass->lastLogout = $row["last_logout"];
            $adminEntityClass->authenticationString = $row["authentication_string"];
            $adminEntityClass->totalRows = $row["total_rows"];

            //add row to table
            array_push($data, $adminEntityClass);
        }

        $rowsRet = pg_num_rows($res);
        $dataAdapter = new cp_databaseAdapter_helper();
        $retData = $dataAdapter->retDataResponse($res, $data, $rowsRet);

        $sqlconnecthelper->dbDisconnect();
        return $retData;

    }

    public function updateEntity(
            $pEntityId
            , $pFirstName = null
            , $pLastName = null
            , $pNickName = null
            , $pName = null
            , $pStatus = null
            , $pApproved = null
            , $pType = null
            , $pAuthenticationId = null
            , $pPrimaryEmailId = null
            , $pPrimaryPhoneId = null
	        , $pLastUpdate = null
            , $pEnterpriseId = null
    ){

        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string
        $res = pg_query_params($connectionString,
                "SELECT * FROM update_entity(
                    $1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12
                )"
                , array(
                    $pEntityId
                    , $pFirstName
                    , $pLastName
                    , $pNickName
                    , $pName
                    , $pStatus
                    , $pApproved
                    , $pType
                    , $pLastUpdate
                    , $pAuthenticationId
                    , $pPrimaryEmailId
                    , $pPrimaryPhoneId
                    ));

        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $pEntityId);
        
        //free up the buffer memory
	pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();
        
        //returns the data
        return $retData;
    }


    public function deleteEntity(
            $pEntityId
            , $pEnterpriseId = null
        ){
        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string
         $res = pg_query_params($connectionString, 
            "SELECT * FROM delete_entity(
                $1
            )"
            , array(
                $pEntityId
            ));
        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $pEntityId);
        
        //free up the buffer memory
	pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();
        
        //returns the data
        return $retData;
    }

}
 
?>
