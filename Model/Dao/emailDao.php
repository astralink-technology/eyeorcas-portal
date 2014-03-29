<?php
/*
 * Email Controller
 */
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/UTCconvertor_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/databaseAdapter_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/idgenerator_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/sqlconnection_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Classes/EmailClass.php');


class cp_email_dao{
        public function createEmail(
            $pEmailAddress = null
            , $pOwnerId = null
            , $pEnterpriseId = null
            ){

            
        $idgeneratorhelper = new cp_idGenerator_helper();
        $emailId = $idgeneratorhelper->generateId();
        
	$utcHelper = new cp_UTCconvertor_helper();
        $pCreateDate = $utcHelper->getCurrentDateTime();
        
        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string
        $res = pg_query_params($connectionString, 
            "SELECT * FROM add_email (
            $1, $2, $3, $4, $5
            )"
            , array(
            $emailId
            , $pEmailAddress
            , $pCreateDate
            , null
	        , $pOwnerId
            ));
        
        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $emailId);
        
        //free up the buffer memory
	pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();
        
        //returns the data
        return $retData;
    }


    public function getEmail(
            $pEmailId
            , $pEmailAddress = null
            , $pOwnerId = null
            , $pPageSize = null
            , $pSkipSize = null
            , $pEnterpriseId = nulls
            ){

        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string

	$res = pg_query_params($connectionString,
                "SELECT * FROM get_email(
                    $1, $2, $3, $4, $5
                )"
                , array(
                    $pEmailId
                    , $pEmailAddress
                    , $pOwnerId
                    , $pPageSize
                    , $pSkipSize
                ));
        $data = array();
	$rows = pg_fetch_all($res);


        for($r = 0; $r < count($rows); $r++){
                $row = $rows[$r];
                $emailClass = new cp_Email();
                $emailClass->emailId = $row["email_id"];
                $emailClass->emailAddress = $row["email_address"];
                $emailClass->createDate = $row["create_date"];
                $emailClass->lastUpdate = $row["last_update"];
                $emailClass->ownerId = $row["owner_id"];
                $emailClass->totalRows = $row["total_rows"];

                //add row to table
                array_push($data, $emailClass);
        }

        $rowsRet = pg_num_rows($res);
        $dataAdapter = new cp_databaseAdapter_helper();
        $retData = $dataAdapter->retDataResponse($res, $data, $rowsRet);
	$sqlconnecthelper->dbDisconnect();
        return $retData;
        
    }

    public function updateEmail(
            $pEmailId
            , $pEmailAddress = null
            , $pOwnerId = null
            , $pLastUpdate = null
            , $pEnterpriseId = null
            ){

        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string
        $res = pg_query_params($connectionString,
                "SELECT * FROM update_email(
                    $1, $2, $3, $4
                )"
                , array(
                    $pEmailId
                    , $pEmailAddress
                    , $pLastUpdate
                    , $pOwnerId
                    ));

        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $pEmailId);
        
        //free up the buffer memory
	pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();
        
        //returns the data
        return $retData;
    }

    public function deleteEmail(
            $pEmailId
            , $pEnterpriseId = null
            ){
        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string
         $res = pg_query_params($connectionString, 
            "SELECT * FROM delete_email(
                $1
            )"
            , array(
                $pEmailId
            ));
        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $pEmailId);
        
        //free up the buffer memory
	pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();
        
        //returns the data
        return $retData;
    }

}
 
?>
