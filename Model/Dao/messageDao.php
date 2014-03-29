<?php
/*
 * Message Controller
 */
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/UTCconvertor_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/databaseAdapter_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/idgenerator_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/sqlconnection_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Classes/MessageClass.php');


class cp_message_dao{
/*
 * Product Registration CRUD
 */
    public function createMessage(
            $pMessage = null
            , $pType = null
            , $pOwnerId = null
            , $pTriggerEvent = null
            , $pEnterpriseId = null
            , $pSubject = null
            ){

        $idgeneratorhelper = new cp_idGenerator_helper();
        $messageId = $idgeneratorhelper->generateId();

	$utcHelper = new cp_UTCconvertor_helper();
        $pCreateDate = $utcHelper->getCurrentDateTime();
        
        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string
        $res = pg_query_params($connectionString, 
            "SELECT * FROM add_message (
            $1, $2, $3, $4, $5, $6, $7, $8
            )"
            , array(
                $messageId
                , $pMessage
                , $pType
                , $pCreateDate
                , null
                , $pOwnerId
                , $pTriggerEvent
                , $pSubject
            ));
        
        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $messageId);
        
        //free up the buffer memory
	pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();
        
        //returns the data
        return $retData;

    }


    public function getMessage(
            $pMessageId
            , $pMessage = null
            , $pType = null
            , $pOwnerId = null
            , $pTriggerEvent = null
            , $pPageSize = null
            , $pSkipSize = null
            , $pEnterpriseId = null
            ){

        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string

	$res = pg_query_params($connectionString,
                "SELECT * FROM get_message(
                    $1, $2, $3, $4, $5, $6, $7
                )"
                , array(
		    $pMessageId
		    , $pMessage
		    , $pType
		    , $pOwnerId
		    , $pTriggerEvent
		    , $pPageSize
		    , $pSkipSize
                ));
        $data = array();
	$rows = pg_fetch_all($res);

        for($r = 0; $r < count($rows); $r++){
                $row = $rows[$r];
                $messageClass = new cp_Message();
                $messageClass->messageId = $row["message_id"];
                $messageClass->message = $row["message"];
                $messageClass->type = $row["type"];
                $messageClass->lastUpdate = $row["last_update"];
                $messageClass->createDate = $row["create_date"];
                $messageClass->ownerId = $row["owner_id"];
                $messageClass->triggerEvent = $row["trigger_event"];
                $messageClass->totalRows = $row["total_rows"];
                $messageClass->subject = $row["subject"];

                //add row to table
                array_push($data, $messageClass);
        }

        $rowsRet = pg_num_rows($res);
        $dataAdapter = new cp_databaseAdapter_helper();
        $retData = $dataAdapter->retDataResponse($res, $data, $rowsRet);
	$sqlconnecthelper->dbDisconnect();
        return $retData;
        
    }

    public function getMessageByEntityId(
            $pOwnerId
            , $pLimit = null
            , $pEnterpriseId = null
            ){

        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string

	$sql = "Select device_relationship.*, message.* from message
		INNER JOIN device_relationship
			ON message.owner_id=device_relationship.device_relationship_id 
		where device_relationship.owner_id = '$pOwnerId' order by message.create_date desc";

	$res = pg_query($connectionString,$sql);
        $data = array();
	$rows = pg_fetch_all($res);
	if(!$pLimit or $pLimit > pg_num_rows($res))
	   $pLimit = pg_num_rows($res);	

        for($r = 0; $r < $pLimit; $r++){
                $row = $rows[$r];
                $messageClass = new cp_Message();
                $messageClass->messageId = $row["message_id"];
                $messageClass->message = $row["message"];
                $messageClass->type = $row["type"];
                $messageClass->lastUpdate = $row["last_update"];
                $messageClass->createDate = $row["create_date"];
      		$messageClass->ownerId = $row["owner_id"];
      		$messageClass->triggerEvent = $row["trigger_event"];
      		//$messageClass->totalRows = $row["total_rows"];

                //add row to table
                array_push($data, $messageClass);
        }

        $rowsRet = pg_num_rows($res);
        $dataAdapter = new cp_databaseAdapter_helper();
        $retData = $dataAdapter->retDataResponse($res, $data, (int)$pLimit);
	$sqlconnecthelper->dbDisconnect();
        return $retData;
        
    }

    public function updateMessage(
            $pMessageId
            , $pMessage = null
            , $pType = null
    	    , $pLastUpdate = null
            , $pOwnerId = null
            , $pTriggerEvent = null
            , $pEnterpriseId = null
            , $pSubject = null
            ){

        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string
        $res = pg_query_params($connectionString,
                "SELECT * FROM update_message(
                    $1, $2, $3, $4, $5, $6, $7
                )"
                , array(
                    $pMessageId
                    , $pMessage
                    , $pType
                    , $pLastUpdate
                    , $pOwnerId
                    , $pTriggerEvent
                    , $pSubject
                    ));

        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $pMessageId);
        
        //free up the buffer memory
	pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();
        
        //returns the data
        return $retData;
    }


    public function deleteMessage(
            $pMessageId
            , $pEnterpriseId = null
            ){
        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true,$pEnterpriseId); // if nothing is passed in, it will return a connection string
         $res = pg_query_params($connectionString, 
            "SELECT * FROM delete_message(
                $1
            )"
            , array(
                $pMessageId
            ));  
        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $pMessageId);
        
        //free up the buffer memory
	pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();
        
        //returns the data
        return $retData;
    }

    public function deleteMessagebyDeviceId(
            $pDeviceId
            , $pEnterpriseId = null
            ){
        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string

         $res = pg_query_params($connectionString, 
            "SELECT * FROM delete_message_by_device_id(
                $1
            )"
            , array(
                $pDeviceId
            ));  
        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $pDeviceId);
        
        //free up the buffer memory
	pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();
        
        //returns the data
        return $retData;
    }

    public function deleteMessagebyOwnerId(
            $pOwnerId
            , $pEnterpriseId = null
            ){
        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string

         $res = pg_query_params($connectionString, 
            "SELECT * FROM delete_message_by_owner_id(
                $1
            )"
            , array(
                $pOwnerId
            ));  
        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $pOwnerId);
        
        //free up the buffer memory
	pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();
        
        //returns the data
        return $retData;
    }

}
 
?>
