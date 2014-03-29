<?php
/*
 * Authentication Controller
 */

require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/UTCconvertor_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/databaseAdapter_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/idgenerator_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/sqlconnection_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Classes/DeviceRelationshipClass.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Classes/EntityDeviceRelationshipDetailsClass.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Classes/DeviceRelationshipMedia.php');

class cp_device_relationship_dao{

    public function createEntityDeviceRelationshipWithValue(
        $pDeviceName = null
        , $pDeviceCode = null
        , $pDeviceStatus = null
        , $pDeviceType = null
        , $pDeviceType2 = null
        , $pDeviceDescription = null
        , $pDeviceOwnerId = null
        , $pOwnerId = null
        , $pName = null
        , $pPush = null
        , $pSms = null
        , $pToken = null
        , $pType = null
        , $pResolution = null
        , $pQuality = null
        , $pHash = null
        , $pSalt = null
        , $pDescription = null
        , $pEnterpriseId = null
    ){

        $idgeneratorhelper = new cp_idGenerator_helper();
        $pDeviceRelationshipId = $idgeneratorhelper->generateId();
        $pDeviceId = $idgeneratorhelper->generateId();
        $pDeviceRelationshipValueId = $idgeneratorhelper->generateId();

        $utcHelper = new cp_UTCconvertor_helper();
        $pCreateDate = $utcHelper->getCurrentDateTime();
        $pDeviceCreateDate = $utcHelper->getCurrentDateTime();
        $pDeviceRelationshipCreateDate = $utcHelper->getCurrentDateTime();

        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string

        $res = pg_query_params($connectionString,
            "SELECT * FROM add_entity_device_relationship_with_values(
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
                    , $23
                    , $24
                    , $25
                    , $26
                    , $27
            )"
            , array(
                $pDeviceId
                , $pDeviceName
                , $pDeviceCode
                , $pDeviceStatus
                , $pDeviceType
                , $pDeviceType2
                , $pDeviceDescription
                , $pDeviceCreateDate
                , null
                , $pDeviceOwnerId
                , $pOwnerId
                , $pDeviceRelationshipId
                , null
                , $pDeviceRelationshipCreateDate
                , $pDeviceRelationshipValueId
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
                , $pDescription
            ));

        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $pDeviceRelationshipId);

        //free up the buffer memory
        pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();

        //returns the data
        return $retData;
    }

    public function getEntityDeviceRelationshipValue(
        $pDeviceId
        , $pOwnerId
        , $pDeviceName = null
        , $pDeviceCode = null
        , $pDeviceStatus = null
        , $pDeviceType = null
        , $pDeviceType2 = null
        , $pDeviceRelationshipName = null
        , $pDeviceRelationshipPush = null
        , $pDeviceRelationshipSms = null
        , $pDeviceRelationshipToken = null
        , $pDeviceRelationshipResolution = null
        , $pDeviceRelationshipQuality = null
        , $pDeviceRelationshipType = null
        , $pPageSize = null
        , $pSkipSize = null
        , $pEnterpriseId = null
    ){
        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string

        $res = pg_query_params($connectionString,
            "SELECT * FROM get_entity_device_relationship_details(
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
            )"
            , array(
                $pDeviceId
                ,$pOwnerId
                ,$pDeviceName
                ,$pDeviceCode
                ,$pDeviceStatus
                ,$pDeviceType
                ,$pDeviceType2
                ,$pDeviceRelationshipName
                ,$pDeviceRelationshipPush
                ,$pDeviceRelationshipSms
                ,$pDeviceRelationshipToken
                ,$pDeviceRelationshipResolution
                ,$pDeviceRelationshipQuality
                ,$pDeviceRelationshipType
                ,$pPageSize
                ,$pSkipSize
            ));
        $data = array();
        $rows = pg_fetch_all($res);

        for($r = 0; $r < count($rows); $r++){
            $row = $rows[$r];

            $entityDeviceRelationshipValueClass = new cp_Entity_Device_Relationship_Details();
            $entityDeviceRelationshipValueClass->deviceId  = $row["device_id"];
            $entityDeviceRelationshipValueClass->deviceName = $row["device_name"];
            $entityDeviceRelationshipValueClass->deviceCode = $row["device_code"];
            $entityDeviceRelationshipValueClass->deviceStatus = $row["device_status"];
            $entityDeviceRelationshipValueClass->deviceType = $row["device_type"];
            $entityDeviceRelationshipValueClass->deviceType2 = $row["device_type2"];
            $entityDeviceRelationshipValueClass->description = $row["description"];
            $entityDeviceRelationshipValueClass->name = $row["name"];
            $entityDeviceRelationshipValueClass->push = $row["push"];
            $entityDeviceRelationshipValueClass->token = $row["token"];
            $entityDeviceRelationshipValueClass->sms = $row["sms"];
            $entityDeviceRelationshipValueClass->quality = $row["quality"];
            $entityDeviceRelationshipValueClass->resolution = $row["resolution"];
            $entityDeviceRelationshipValueClass->deviceLastUpdate = $row["device_last_update"];
            $entityDeviceRelationshipValueClass->lastUpdate = $row["last_update"];
            $entityDeviceRelationshipValueClass->ownerId = $row["owner_id"];
            $entityDeviceRelationshipValueClass->deviceRelationshipValueId = $row["device_relationship_value_id"];
            $entityDeviceRelationshipValueClass->deviceRelationshipId = $row["device_relationship_id"];
            $entityDeviceRelationshipValueClass->totalRows = $row["total_rows"];

            //add row to table
            array_push($data, $entityDeviceRelationshipValueClass);
        }

        $rowsRet = pg_num_rows($res);
        $dataAdapter = new cp_databaseAdapter_helper();
        $retData = $dataAdapter->retDataResponse($res, $data, $rowsRet);

        $sqlconnecthelper->dbDisconnect();
        return $retData;
    }

    public function getEntityDeviceRelationship(
        $pDeviceId
        , $pOwnerId
        , $pName = null
        , $pCode = null
        , $pStatus = null
        , $pType = null
        , $pType2 = null
        , $pPageSize = null
        , $pSkipSize = null
        , $pEnterpriseId = null
    ){

        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string

        $res = pg_query_params($connectionString,
            "SELECT * FROM get_entity_device_relationship(
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
            $entityRelatedDeviceClass = new cp_Entity_Device_Relationship();
            $entityRelatedDeviceClass->deviceId = $row["device_id"];
            $entityRelatedDeviceClass->name = $row["name"];
            $entityRelatedDeviceClass->code = $row["code"];
            $entityRelatedDeviceClass->status = $row["status"];
            $entityRelatedDeviceClass->type = $row["type"];
            $entityRelatedDeviceClass->type2 = $row["type2"];
            $entityRelatedDeviceClass->description = $row["description"];
            $entityRelatedDeviceClass->createDate = $row["create_date"];
            $entityRelatedDeviceClass->lastUpdate = $row["last_update"];
            $entityRelatedDeviceClass->ownerId = $row["owner_id"];
            $entityRelatedDeviceClass->totalRows = $row["total_rows"];

            //add row to table
            array_push($data, $entityRelatedDeviceClass);
        }

        $rowsRet = pg_num_rows($res);
        $dataAdapter = new cp_databaseAdapter_helper();
        $retData = $dataAdapter->retDataResponse($res, $data, $rowsRet);

        $sqlconnecthelper->dbDisconnect();
        return $retData;
    }


    public function getDeviceRelationshipMedia(
        $pMediaId
      , $pType = null
      , $pStatus = null
      , $pOwnerId = null
      , $pDeviceId = null
      , $pDeviceRelationshipId = null
      , $pPageSize = null
      , $pSkipSize = null
    , $pEnterpriseId = null
    ){

        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string

        $res = pg_query_params($connectionString,
            "SELECT * FROM get_device_relationship_media(
                    $1
                    , $2
                    , $3
                    , $4
                    , $5
                    , $6
                    , $7
                    , $8
            )"
            , array(
                $pMediaId
                , $pType
                , $pStatus
                , $pOwnerId
                , $pDeviceId
                , $pDeviceRelationshipId
                , $pPageSize
                , $pSkipSize
            ));
        $data = array();
        $rows = pg_fetch_all($res);

        for($r = 0; $r < count($rows); $r++){
            $row = $rows[$r];
            $deviceRelationshipMediaClass= new cp_Device_Relationship_Media();
            $deviceRelationshipMediaClass->mediaId = $row["media_id"];
            $deviceRelationshipMediaClass->title = $row["title"];
            $deviceRelationshipMediaClass->type = $row["type"];
            $deviceRelationshipMediaClass->fileName = $row["file_name"];
            $deviceRelationshipMediaClass->fileType = $row["file_type"];
            $deviceRelationshipMediaClass->mediaUrl = $row["media_url"];
            $deviceRelationshipMediaClass->status = $row["status"];
            $deviceRelationshipMediaClass->createDate = $row["create_date"];
            $deviceRelationshipMediaClass->description = $row["description"];
            $deviceRelationshipMediaClass->imgUrl = $row["img_url"];
            $deviceRelationshipMediaClass->imgUrl2 = $row["img_url2"];
            $deviceRelationshipMediaClass->imgUrl3 = $row["img_url3"];
            $deviceRelationshipMediaClass->imgUrl4 = $row["img_url4"];
            $deviceRelationshipMediaClass->ownerId = $row["owner_id"];
            $deviceRelationshipMediaClass->deviceId = $row["device_id"];
            $deviceRelationshipMediaClass->deviceRelationshipId = $row["device_relationship_id"];
            $deviceRelationshipMediaClass->deviceRelationshipCreateDate = $row["device_relationship_create_date"];
            $deviceRelationshipMediaClass->totalRows = $row["total_rows"];

            //add row to table
            array_push($data, $deviceRelationshipMediaClass);
        }

        $rowsRet = pg_num_rows($res);
        $dataAdapter = new cp_databaseAdapter_helper();
        $retData = $dataAdapter->retDataResponse($res, $data, $rowsRet);

        $sqlconnecthelper->dbDisconnect();
        return $retData;
    }


    public function getDeviceRelationship(
        $pDeviceRelationshipId
        , $pDeviceId = null
        , $pOwnerId = null
        , $pPageSize = null
        , $pSkipSize = null
        , $pEnterpriseId = null
    ){
        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string

        $res = pg_query_params($connectionString,
            "SELECT * FROM get_device_relationship(
                    $1
                    , $2
                    , $3
                    , $4
                    , $5
            )"
            , array(
                $pDeviceRelationshipId
                , $pDeviceId
                , $pOwnerId
                , $pPageSize
                , $pSkipSize
            ));
        $data = array();
        $rows = pg_fetch_all($res);

        for($r = 0; $r < count($rows); $r++){
            $row = $rows[$r];

            $deviceRelationshipClass = new cp_Device_Relationship();
            $deviceRelationshipClass->deviceRelationshipId  = $row["device_relationship_id"];
            $deviceRelationshipClass->deviceId = $row["device_id"];
            $deviceRelationshipClass->ownerId = $row["owner_id"];
            $deviceRelationshipClass->lastUpdate = $row["last_update"];
            $deviceRelationshipClass->createDate = $row["create_date"];
            $deviceRelationshipClass->totalRows = $row["total_rows"];

            //add row to table
            array_push($data, $deviceRelationshipClass);
        }

        $rowsRet = pg_num_rows($res);
        $dataAdapter = new cp_databaseAdapter_helper();
        $retData = $dataAdapter->retDataResponse($res, $data, $rowsRet);

        $sqlconnecthelper->dbDisconnect();
        return $retData;
    }

    public function createDeviceRelationship(
            $pDeviceId = null
            , $pOwnerId = null
            , $pEnterpriseId = null
            ){

        $idgeneratorhelper = new cp_idGenerator_helper();
        $pDeviceRelationshipId = $idgeneratorhelper->generateId();

        $utcHelper = new cp_UTCconvertor_helper();
        $pCreateDate = $utcHelper->getCurrentDateTime();

        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string

        $res = pg_query_params($connectionString,
            "SELECT * FROM add_device_relationship(
                    $1
                    , $2
                    , $3
                    , $4
                    , $5
            )"
            , array(
                $pDeviceRelationshipId
                , $pDeviceId
                , $pOwnerId
                , null
                , $pCreateDate
            ));

        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $pDeviceRelationshipId);

        //free up the buffer memory
        pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();

        //returns the data
        return $retData;
    }

    public function updateDeviceRelationship(
        $pDeviceRelationshipId
        , $pDeviceId = null
        , $pOwnerId = null
        , $pLastUpdate = null
        , $pEnterpriseId = null
    ){

        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string
        $res = pg_query_params($connectionString,
            "SELECT * FROM update_device_relationship(
                $1
                , $2
                , $3
                , $4
            )"
            , array(
                $pDeviceRelationshipId
                , $pDeviceId
                , $pOwnerId
                , $pLastUpdate
            ));

        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $pDeviceRelationshipId);

        //free up the buffer memory
        pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();

        //returns the data
        return $retData;
    }


    public function deleteDeviceRelationship(
        $pDeviceRelationshipId
        , $pEnterpriseId = null
    ){
        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string
        $res = pg_query_params($connectionString,
            "SELECT * FROM delete_device_relationship(
                $1
            )"
            , array(
                $pDeviceRelationshipId
            ));
        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $pDeviceRelationshipId);

        //free up the buffer memory
        pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();

        //returns the data
        return $retData;
    }

}
 
?>
