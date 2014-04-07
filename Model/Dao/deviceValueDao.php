<?php
/*
 * Device Value Controller
 */
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/UTCconvertor_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/databaseAdapter_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/idgenerator_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/sqlconnection_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Classes/DeviceValueClass.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Classes/DeviceDetailClass.php');


class cp_create_device_value_dao{
    public function createDeviceValue(
            $pPush = null
            , $pSms = null
            , $pToken = null
            , $pType = null
            , $pResolution = null
            , $pQuality = null
            , $pHash = null
            , $pSalt = null
            , $pDeviceId = null
            , $pDescription = null
            , $pEnterpriseId = null
            , $pLocationName = null
            , $pLatitude = null
            , $pLongitude = null
            , $pAppVersion = null
            , $pFirmwareVersion = null
        ){

        $idgeneratorhelper = new cp_idGenerator_helper();
        $pDeviceValueId = $idgeneratorhelper->generateId();

	    $utcHelper = new cp_UTCconvertor_helper();
        $pCreateDate = $utcHelper->getCurrentDateTime();
        
        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string

        $res = pg_query_params($connectionString, 
            "SELECT * FROM add_device_value(
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
                    , $15
                    , $16
                    , $17
                    , $18
            )"
            , array(
                $pDeviceValueId
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
                , $pDeviceId
		        , $pDescription
                , $pLocationName
                , $pLatitude
                , $pLongitude
                , $pAppVersion
                , $pFirmwareVersion
            ));
        
        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $pDeviceValueId);
        
        //free up the buffer memory
	    pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();
        
        //returns the data
        return $retData;
    }


    public function getDeviceValue(
            $pDeviceValueId
            , $pPush = null
            , $pSms = null
            , $pToken  = null
            , $pType  = null
            , $pResolution  = null
            , $pQuality  = null
            , $pDeviceId  = null
            , $pPageSize = null
            , $pSkipSize  = null
            , $pEnterpriseId = null
            , $pLocationName = null
            , $pLatitude = null
            , $pLongitude = null
            , $pAppVersion = null
            , $pFirmwareVersion = null
        ){
        
        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string

	        $res = pg_query_params($connectionString,
                "SELECT * FROM get_device_value(
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
                        , $15
                )"
                , array(
                    $pDeviceValueId
                    , $pPush
                    , $pSms
                    , $pToken
                    , $pType
                    , $pResolution
                    , $pQuality
                    , $pDeviceId
                    , $pPageSize
                    , $pSkipSize
                    , $pLocationName
                    , $pLatitude
                    , $pLongitude
                    , $pAppVersion
                    , $pFirmwareVersion
                ));
        $data = array();
	    $rows = pg_fetch_all($res);

        for($r = 0; $r < count($rows); $r++){
                $row = $rows[$r];
                $deviceValueClass = new cp_Device_Value;
                $deviceValueClass->deviceValueId = $row["device_value_id"];
                $deviceValueClass->push = $row["push"];
                $deviceValueClass->sms = $row["sms"];
                $deviceValueClass->token = $row["token"];
                $deviceValueClass->type = $row["type"];
                $deviceValueClass->resolution = $row["resolution"];
                $deviceValueClass->quality = $row["quality"];
                $deviceValueClass->hash = $row["hash"];
                $deviceValueClass->salt = $row["salt"];
                $deviceValueClass->createDate = $row["create_date"];
                $deviceValueClass->lastUpdate = $row["last_update"];
                $deviceValueClass->deviceId = $row["device_id"];
                $deviceValueClass->description = $row["description"];
                $deviceValueClass->locationName = $row["location_name"];
                $deviceValueClass->latitude = $row["latitude"];
                $deviceValueClass->longitude = $row["longitude"];
                $deviceValueClass->appVersion = $row["app_version"];
                $deviceValueClass->firmwareVersion = $row["firmware_version"];
                $deviceValueClass->totalRows = $row["total_rows"];
                //add row to table
                array_push($data, $deviceValueClass);
        }

        $rowsRet = pg_num_rows($res);
        $dataAdapter = new cp_databaseAdapter_helper();
        $retData = $dataAdapter->retDataResponse($res, $data, $rowsRet);

	    $sqlconnecthelper->dbDisconnect();
        return $retData;
    }


    public function updateDeviceValue(
                $pDeviceValueId
                , $pPush = null
                , $pSms = null
                , $pToken = null
                , $pType = null
                , $pResolution = null
                , $pQuality = null
                , $pHash = null
                , $pSalt = null
                , $pLastUpdate = null
                , $pDeviceId = null
                , $pDescription = null
                , $pEnterpriseId = null
                , $pLocationName = null
                , $pLatitude = null
                , $pLongitude = null
                , $pAppVersion = null
                , $pFirmwareVersion = null
            ){

        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string
        $res = pg_query_params($connectionString,
                "SELECT * FROM update_device_value(
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
                    , $15
                    , $16
                    , $17
                )"
                , array(
                    $pDeviceValueId
                    , $pPush
                    , $pSms
                    , $pToken
                    , $pType
                    , $pResolution
                    , $pQuality
                    , $pHash
                    , $pSalt
                    , $pLastUpdate
                    , $pDeviceId
		            , $pDescription
                    , $pLocationName
                    , $pLatitude
                    , $pLongitude
                    , $pAppVersion
                    , $pFirmwareVersion
                ));

        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $pDeviceValueId);
        
        //free up the buffer memory
	    pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();
        
        //returns the data
        return $retData;
    }


    public function deleteDeviceValue(
            $pDeviceValueId
            , $pDeviceId
            , $pEnterpriseId = null
            ){
        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string
         $res = pg_query_params($connectionString, 
            "SELECT * FROM delete_device_value(
                $1
                , $2
            )"
            , array(
                $pDeviceValueId
	        , $pDeviceId
            ));
        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $pDeviceValueId);
        
        //free up the buffer memory
	pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();
        
        //returns the data
        return $retData;
    }


}
 
?>
