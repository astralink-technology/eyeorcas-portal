<?php
/*
 * Device Controller
 */
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/UTCconvertor_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/databaseAdapter_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/idgenerator_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/sqlconnection_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Classes/DeviceClass.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Classes/DeviceDetailClass.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Classes/EntityDeviceRelationshipClass.php');


class cp_device_dao{

    public function getDevice(
        $pDeviceId
        , $pName = null
        , $pCode = null
        , $pStatus = null
        , $pType = null
        , $pType2 = null
        , $pOwnerId = null
        , $pPageSize = null
        , $pSkipSize = null
        , $pEnterpriseId = null
    ){

        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string

        $res = pg_query_params($connectionString,
            "SELECT * FROM get_device(
                    $1
                    , $2
                    , $3
                    , $4
                    , $5
                    , $6
                    , $7
                    , $8
                    , $9
            )"
            , array(
                $pDeviceId
            , $pName
            , $pCode
            , $pStatus
            , $pType
            , $pType2
            , $pOwnerId
            , $pPageSize
            , $pSkipSize
            ));
        $data = array();
        $rows = pg_fetch_all($res);

        for($r = 0; $r < count($rows); $r++){
            $row = $rows[$r];
            $deviceClass = new cp_Device();
            $deviceClass->deviceId = $row["device_id"];
            $deviceClass->name = $row["name"];
            $deviceClass->code = $row["code"];
            $deviceClass->status = $row["status"];
            $deviceClass->type = $row["type"];
            $deviceClass->type2 = $row["type2"];
            $deviceClass->createDate = $row["create_date"];
            $deviceClass->lastUpdate = $row["last_update"];
            $deviceClass->ownerId = $row["owner_id"];
            $deviceClass->totalRows = $row["total_rows"];

            //add row to table
            array_push($data, $deviceClass);
        }

        $rowsRet = pg_num_rows($res);
        $dataAdapter = new cp_databaseAdapter_helper();
        $retData = $dataAdapter->retDataResponse($res, $data, $rowsRet);

        $sqlconnecthelper->dbDisconnect();
        return $retData;
    }


    public function getDeviceDetails(
        $pDeviceId
        , $pName = null
        , $pCode = null
        , $pStatus = null
        , $pType = null
        , $pType2 = null
        , $pPush = null
        , $pToken = null
        , $pSms = null
        , $pQuality = null
        , $pResolution = null
        , $pDeviceValueType = null
        , $pOwnerId = null
        , $pPageSize = null
        , $pSkipSize = null
        , $pEnterpriseId = null
    ){
        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string

        $res = pg_query_params($connectionString,
            "SELECT * FROM get_device_details(
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
                $pDeviceId
                , $pName
                , $pCode
                , $pStatus
                , $pType
                , $pType2
                , $pPush
                , $pToken
                , $pSms
                , $pQuality
                , $pResolution
                , $pDeviceValueType
                , $pOwnerId
                , $pPageSize
                , $pSkipSize
            ));
        $data = array();
        $rows = pg_fetch_all($res);

        for($r = 0; $r < count($rows); $r++){
            $row = $rows[$r];

            $deviceDetailClass = new cp_Device_Details();
            $deviceDetailClass->deviceId  = $row["device_id"];
            $deviceDetailClass->deviceValueId = $row["device_value_id"];
            $deviceDetailClass->name = $row["name"];
            $deviceDetailClass->code = $row["code"];
            $deviceDetailClass->status = $row["status"];
            $deviceDetailClass->type = $row["type"];
            $deviceDetailClass->type2 = $row["type2"];
            $deviceDetailClass->description = $row["description"];
            $deviceDetailClass->push = $row["push"];
            $deviceDetailClass->token = $row["token"];
            $deviceDetailClass->sms = $row["sms"];
            $deviceDetailClass->quality = $row["quality"];
            $deviceDetailClass->resolution = $row["resolution"];
            $deviceDetailClass->deviceValueType = $row["device_value_type"];
            $deviceDetailClass->lastUpdate = $row["last_update"];
            $deviceDetailClass->deviceLastUpdate = $row["device_last_update"];
            $deviceDetailClass->ownerId = $row["owner_id"];
            $deviceDetailClass->totalRows = $row["total_rows"];

            //add row to table
            array_push($data, $deviceDetailClass);
        }

        $rowsRet = pg_num_rows($res);
        $dataAdapter = new cp_databaseAdapter_helper();
        $retData = $dataAdapter->retDataResponse($res, $data, $rowsRet);

        $sqlconnecthelper->dbDisconnect();
        return $retData;
    }

    public function createDevice(
        $pName = null
        , $pCode = null
        , $pStatus = null
        , $pType = null
        , $pType2 = null
        , $pDescription = null
        , $pOwnerId = null
        , $pEnterpriseId = null
    ){

        $idgeneratorhelper = new cp_idGenerator_helper();
        $pDeviceId = $idgeneratorhelper->generateId();

        $utcHelper = new cp_UTCconvertor_helper();
        $pCreateDate = $utcHelper->getCurrentDateTime();

        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string

        $res = pg_query_params($connectionString,
            "SELECT * FROM add_device(
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
            )"
            , array(
                $pDeviceId
                , $pName
                , $pCode
                , $pStatus
                , $pType
                , $pType2
                , $pDescription
                , $pCreateDate
                , null
                , $pOwnerId
            ));

        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $pDeviceId);

        //free up the buffer memory
        pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();

        //returns the data
        return $retData;
    }

    public function createDeviceWithValues(
        $pName = null
        , $pCode = null
        , $pStatus = null
        , $pType = null
        , $pType2 = null
        , $pDescription = null
        , $pOwnerId = null
        , $pPush = null
        , $pSms = null
        , $pToken = null
        , $pDeviceValueType = null
        , $pResolution = null
        , $pQuality = null
        , $pHash = null
        , $pSalt = null
        , $pDeviceValueDescription = null
        , $pEnterpriseId = null
        ){

        $idgeneratorhelper = new cp_idGenerator_helper();
        $pDeviceId = $idgeneratorhelper->generateId();
        $pDeviceValueId = $idgeneratorhelper->generateId();

	    $utcHelper = new cp_UTCconvertor_helper();
        $pCreateDate = $utcHelper->getCurrentDateTime();
        $pDeviceValueCreateDate = $utcHelper->getCurrentDateTime();

        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string

        $res = pg_query_params($connectionString,
            "SELECT * FROM add_device_with_values(
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
		            , $19
		            , $20
		            , $21
		            , $22
            )"
            , array(
                $pDeviceId
                , $pName
                , $pCode
                , $pStatus
                , $pType
                , $pType2
                , $pDescription
                , $pCreateDate
                , null
                , $pOwnerId
                , $pDeviceValueId
                , $pPush
                , $pSms
                , $pToken
                , $pDeviceValueType
                , $pResolution
                , $pQuality
                , $pHash
                , $pSalt
                , $pDeviceValueCreateDate
                , null
                , $pDeviceValueDescription
            ));

        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $pDeviceId);

        //free up the buffer memory
	    pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();

        //returns the data
        return $retData;
    }


    public function updateDevice(
        $pDeviceId
        , $pName = null
        , $pCode = null
        , $pStatus = null
        , $pType = null
        , $pType2 = null
        , $pDescription = null
        , $pLastUpdate = null
        , $pOwnerId = null
        , $pEnterpriseId = null
    ){

        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string
        $res = pg_query_params($connectionString,
            "SELECT * FROM update_device(
                $1
                , $2
                , $3
                , $4
                , $5
                , $6
                , $7
                , $8
                , $9
            )"
            , array(
                $pDeviceId
                , $pName
                , $pCode
                , $pStatus
                , $pType
                , $pType2
                , $pDescription
                , $pLastUpdate
                , $pOwnerId
            ));

        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $pDeviceId);

        //free up the buffer memory
        pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();

        //returns the data
        return $retData;
    }


    public function deleteDevice(
        $pDeviceId
        , $pEnterpriseId = null
    ){
        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string
        $res = pg_query_params($connectionString,
            "SELECT * FROM delete_device(
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
}
 
?>
