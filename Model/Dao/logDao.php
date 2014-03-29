<?php
/*
 * Log Controller
 */
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/UTCconvertor_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/databaseAdapter_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/idgenerator_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/sqlconnection_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Classes/LogClass.php');


class cp_log_dao{
/*
 * Log Registration CRUD
 */
    public function createLog(
            $pMessage = null
	        , $pTitle = null
            , $pType = null
            , $pLogUrl = null
            , $pStatus = null
            , $pOwnerId = null
            , $pEnterpriseId = null
            ){

        $idgeneratorhelper = new cp_idGenerator_helper();
        $logId = $idgeneratorhelper->generateId();
	
	$utcHelper = new cp_UTCconvertor_helper();
        $pCreateDate = $utcHelper->getCurrentDateTime();
        
        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseIds); // if nothing is passed in, it will return a connection string
        $res = pg_query_params($connectionString, 
            "SELECT * FROM add_log(
            $1, $2, $3, $4, $5, $6, $7, $8
            )"
            , array(
                $logId
                , $pMessage
                , $pTitle
                , $pType
                , $pLogUrl
                , $pStatus
                , $pCreateDate
                , $pOwnerId
            ));
        
        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $logId);
        
        //free up the buffer memory
	pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();
        
        //returns the data
        return $retData;

    }


    public function getLog(
            $plogId
            , $pMessage = null
	    , $pTitle = null
            , $pType = null
            , $pLogUrl = null
            , $pStatus = null
            , $pOwnerId = null
            , $pPageSize = null
            , $pSkipSize = null
            , $pEnterpriseId = null
            ){
        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string

	$res = pg_query_params($connectionString,
                "SELECT * FROM get_log(
                    $1, $2, $3, $4, $5, $6, $7, $8, $9
                )"
                , array(
                    $plogId
                    , $pMessage
                    , $pTitle
                    , $pType
                    , $pLogUrl
                    , $pStatus
                    , $pOwnerId
                    , $pPageSize
                    , $pSkipSize
                ));
        $data = array();
	$rows = pg_fetch_all($res);

        for($r = 0; $r < count($rows); $r++){
                $row = $rows[$r];
                $logClass = new cp_Log();
                $logClass->logId = $row["log_id"];
		        $logClass->message = $row["message"];
                $logClass->title = $row["title"];
                $logClass->type = $row["type"];
                $logClass->logURL = $row["log_url"];
                $logClass->status = $row["status"];
                $logClass->createDate = $row["create_date"];
		        $logClass->ownerId = $row["owner_id"];
		        $logClass->totalRows = $row["total_rows"];

                //add row to table
                array_push($data, $logClass);
        }

        $rowsRet = pg_num_rows($res);
        $dataAdapter = new cp_databaseAdapter_helper();
        $retData = $dataAdapter->retDataResponse($res, $data, $rowsRet);
	$sqlconnecthelper->dbDisconnect();
        return $retData;
        
    }

    public function updateLog(
            $plogId
            , $pMessage = null
            , $pTitle = null
            , $pType = null
            , $pLogUrl = null
            , $pStatus = null
            , $pOwnerId = null
            , $pEnterpriseId = null
            ){

        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string
        $res = pg_query_params($connectionString,
                "SELECT * FROM update_log(
                    $1, $2, $3, $4, $5, $6, $7
                )"
                , array(
                    $plogId
                    , $pMessage
                    , $pTitle
                    , $pType
                    , $pLogUrl
                    , $pStatus
                    , $pOwnerId
                    ));

        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $plogId);
        
        //free up the buffer memory
	pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();
        
        //returns the data
        return $retData;
    }


    public function deleteLog(
            $pLogId
            , $pEnterpriseId = null
            ){
        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string
         $res = pg_query_params($connectionString, 
            "SELECT * FROM delete_log(
                $1
            )"
            , array(
                $pLogId
            ));
        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $pLogId);
        
        //free up the buffer memory
	pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();
        
        //returns the data
        return $retData;
    }

}
 
?>
