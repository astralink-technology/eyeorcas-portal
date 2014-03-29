<?php
/*
 * Device Relationship Value Controller
 */
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/UTCconvertor_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/databaseAdapter_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/idgenerator_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/sqlconnection_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Classes/DeviceRelationshipValueClass.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Classes/DeviceDetailClass.php');


class cp_device_relationship_value_dao{
    public function createDeviceRelationshipValue(
            $pName = null
            , $pPush = null
            , $pSms = null
            , $pToken = null
            , $pType = null
            , $pResolution = null
            , $pQuality = null
            , $pHash = null
            , $pSalt = null
            , $pDeviceRelationshipId = null
            , $pDescription = null
            , $pEnterpriseId = null
        ){

        $idgeneratorhelper = new cp_idGenerator_helper();
        $pDeviceRelationshipValueId = $idgeneratorhelper->generateId();

	    $utcHelper = new cp_UTCconvertor_helper();
        $pCreateDate = $utcHelper->getCurrentDateTime();
        
        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string

        $res = pg_query_params($connectionString, 
            "SELECT * FROM add_device_relationship_value(
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
		    , $14
            )"
            , array(
                $pDeviceRelationshipValueId
                , $pName
                , $pPush
                , $pSms
                , $pToken
                , $pType
                , $pResolution
                , $pQuality
                , $pHash
                , $pSalt
                , $pCreateDate
                , null
                , $pDeviceRelationshipId
		, $pDescription
            ));
        
        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $pDeviceRelationshipValueId);
        
        //free up the buffer memory
	    pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();
        
        //returns the data
        return $retData;
    }


    public function getDeviceRelationshipValue(
            $pDeviceRelationshipValueId
            , $pName = null
            , $pPush = null
            , $pSms = null
            , $pToken  = null
            , $pType  = null
            , $pResolution  = null
            , $pQuality  = null
            , $pDeviceRelationshipId  = null
            , $pPageSize = null
            , $pSkipSize = null
            , $pEnterpriseId = null
            ){
        
        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string

	        $res = pg_query_params($connectionString,
                "SELECT * FROM get_device_relationship_value(
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
                )"
                , array(
                    $pDeviceRelationshipValueId
                    , $pName
                    , $pPush
                    , $pSms
                    , $pToken
                    , $pType
                    , $pResolution
                    , $pQuality
                    , $pDeviceRelationshipId
                    , $pPageSize
                    , $pSkipSize
                ));
        $data = array();
	    $rows = pg_fetch_all($res);

        for($r = 0; $r < count($rows); $r++){
                $row = $rows[$r];
                $deviceRelationshipValueClass = new cp_Device_Relationship_Value;
                $deviceRelationshipValueClass->deviceRelationshipValueId = $row["device_relationship_value_id"];
                $deviceRelationshipValueClass->push = $row["push"];
                $deviceRelationshipValueClass->sms = $row["sms"];
                $deviceRelationshipValueClass->token = $row["token"];
                $deviceRelationshipValueClass->type = $row["type"];
                $deviceRelationshipValueClass->resolution = $row["resolution"];
                $deviceRelationshipValueClass->quality = $row["quality"];
                $deviceRelationshipValueClass->hash = $row["hash"];
                $deviceRelationshipValueClass->salt = $row["salt"];
                $deviceRelationshipValueClass->createDate = $row["create_date"];
                $deviceRelationshipValueClass->lastUpdate = $row["last_update"];
                $deviceRelationshipValueClass->deviceRelationshipId = $row["device_relationship_id"];
                $deviceRelationshipValueClass->description = $row["description"];
                $deviceRelationshipValueClass->totalRows = $row["total_rows"];
                //add row to table
                array_push($data, $deviceRelationshipValueClass);
        }

        $rowsRet = pg_num_rows($res);
        $dataAdapter = new cp_databaseAdapter_helper();
        $retData = $dataAdapter->retDataResponse($res, $data, $rowsRet);

	    $sqlconnecthelper->dbDisconnect();
        return $retData;
    }


    public function updateDeviceRelationshipValue(
                $pDeviceRelationshipValueId
                , $pName = null
                , $pPush = null
                , $pSms = null
                , $pToken = null
                , $pType = null
                , $pResolution = null
                , $pQuality = null
                , $pHash = null
                , $pSalt = null
                , $pLastUpdate = null
                , $pDeviceRelationshipId = null
	            , $pDescription = null
                , $pEnterpriseId = null
            ){

        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string
        $res = pg_query_params($connectionString,
                "SELECT * FROM update_device_relationship_value(
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
                )"
                , array(
                    $pDeviceRelationshipValueId
                    , $pName
                    , $pPush
                    , $pSms
                    , $pToken
                    , $pType
                    , $pResolution
                    , $pQuality
                    , $pHash
                    , $pSalt
                    , $pLastUpdate
                    , $pDeviceRelationshipId
		            , $pDescription
                ));

        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $pDeviceRelationshipValueId);
        
        //free up the buffer memory
	    pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();
        
        //returns the data
        return $retData;
    }


    public function deleteDeviceRelationshipValue(
            $pDeviceRelationshipValueId
            , $pEnterpriseId = null
            ){

        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string
         $res = pg_query_params($connectionString,
            "SELECT * FROM delete_device_relationship_value(
                $1
            )"
            , array(
                $pDeviceRelationshipValueId
            ));
        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $pDeviceRelationshipValueId);

        //free up the buffer memory
	    pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();
        
        //returns the data
        return $retData;
    }

    public function getUserDevicesDetails(
        $pOwnerId
        ){
        
        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(); // if nothing is passed in, it will return a connection string
	// redo
	$sql = "Select device_relationship_value.*, device.type, device.type2, device.code, device.owner_id, device.device_id, device.code, device_relationship_value.type as device_relationship_value_type, device_relationship_value.description as device_relationship_value_description from device
		INNER JOIN device_relationship
			ON device.device_id=device_relationship.device_id 
		INNER JOIN device_relationship_value 
			ON device_relationship.device_relationship_id=device_relationship_value.device_relationship_id 
		where device_relationship.owner_id = '$pOwnerId'";

	

	$res = pg_query($connectionString,$sql);
        $data = array();
	$rows = pg_fetch_all($res);

        for($r = 0; $r < count($rows); $r++){
                $row = $rows[$r];

                $deviceDetailClass = new cp_Device_Details;
                $deviceDetailClass->deviceId = $row["device_id"];
                $deviceDetailClass->deviceRelationshipValueId = $row["device_relationship_value_id"];
                $deviceDetailClass->push = $row["push"];
		$deviceDetailClass->name = $row["name"];
		$deviceDetailClass->ownerId = $row["owner_id"];
		$deviceDetailClass->code = $row["code"];
                $deviceDetailClass->sms = $row["sms"];
                $deviceDetailClass->token = $row["token"];
                $deviceDetailClass->type = $row["type"];
                $deviceDetailClass->type2 = $row["type2"];
                $deviceDetailClass->resolution = $row["resolution"];
                $deviceDetailClass->quality = $row["quality"];
                $deviceDetailClass->hash = $row["hash"];
                $deviceDetailClass->salt = $row["salt"];
                $deviceDetailClass->createDate = $row["create_date"];
                $deviceDetailClass->lastUpdate = $row["last_update"];
                $deviceDetailClass->deviceRelationshipId = $row["device_relationship_id"];
                $deviceDetailClass->description = $row["device_relationship_value_description"];
		$deviceDetailClass->deviceRelationshipValueType = $row["device_relationship_value_type"];
		$code = $row["code"];

        	$sqlconnecthelperToOtherDb = new cp_sqlConnection_helper();
        	$connectionStringToOtherDb = $sqlconnecthelperToOtherDb->dbConnect(null, null, "orcas_monitor", "23.21.214.219", "5432", "ubuntu", "astralink");

		$sqlStatus = "Select * from monitor where camera_id = '$code'";

		$resStatus = pg_query($connectionStringToOtherDb,$sqlStatus);

		$rowsRet = pg_num_rows($resStatus);

		if($rowsRet)
			$deviceDetailClass->status = "Online";
		else
			$deviceDetailClass->status = "Offline";

                //add row to table
                array_push($data, $deviceDetailClass);
		$sqlconnecthelperToOtherDb->dbDisconnect();
        }

        $rowsRet = pg_num_rows($res);
        $dataAdapter = new cp_databaseAdapter_helper();
        $retData = $dataAdapter->retDataResponse($res, $data, $rowsRet);

	$sqlconnecthelper->dbDisconnect();
        return $retData;
    }

}
 
?>
