<?php
/*
 * Device Session Controller
 */
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/UTCconvertor_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/databaseAdapter_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/idgenerator_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/sqlconnection_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Classes/DeviceSessionClass.php');


class cp_device_session_dao{
    public function createDeviceSession(
            $pDeviceId = null
            , $pConnectedDeviceId = null
            , $pStatus = null
            , $pEnterpriseId = null
            ){

	$utcHelper = new cp_UTCconvertor_helper();
        $pCreateDate = $utcHelper->getCurrentDateTime();
        

        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string


        $res = pg_query_params($connectionString,
            "SELECT * FROM add_device_session(
                    $1
                    , $2
                    , $3
                    , $4
            )"
            , array(
                $pDeviceId
                , $pConnectedDeviceId
                , $pStatus
                , $pCreateDate
            ));
        
        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $pDeviceId);
        
        //free up the buffer memory
	pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();
        
        //returns the data
        return $retData;

    }


    public function getDeviceSession(
            $pDeviceId
            , $pConnectedDeviceId = null
            , $pStatus = null
            , $pPageSize = null
            , $pSkipSize = null
            , $pEnterpriseId = null
            ){

        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string

        $res = pg_query_params($connectionString,
            "SELECT * FROM get_device_session(
                    $1
                    , $2
                    , $3
                    , $4
                    , $5
            )"
            , array(
                $pDeviceId
                , $pConnectedDeviceId
                , $pStatus
                , $pPageSize
                , $pSkipSize
            ));
        $data = array();
        $rows = pg_fetch_all($res);

        for($r = 0; $r < count($rows); $r++){
                $row = $rows[$r];
                $device_sessionClass = new cp_Device_Session();
                $device_sessionClass->deviceId = $row["device_id"];
                $device_sessionClass->connectionDeviceId = $row["connected_device_id"];
		        $device_sessionClass->status = $row["status"];
                $device_sessionClass->createDate = $row["create_date"];
                $device_sessionClass->totalRows = $row["total_rows"];

                //add row to table
                array_push($data, $device_sessionClass);
        }

        $rowsRet = pg_num_rows($res);
        $dataAdapter = new cp_databaseAdapter_helper();
        $retData = $dataAdapter->retDataResponse($res, $data, $rowsRet);
	$sqlconnecthelper->dbDisconnect();
        return $retData;
        
    }

    public function updateDeviceSession(
            $pDeviceId
            , $pConnectedDeviceID = null
            , $pStatus = null
            , $pEnterpriseId = null
            ){

        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string
        $res = pg_query_params($connectionString,
            "SELECT * FROM update_device_session(
                $1
                , $2
                , $3
            )"
            , array(
                $pDeviceId
                , $pConnectedDeviceID
                , $pStatus
            ));
        
        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $pDeviceId);
        
        //free up the buffer memory
	pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();
        
        //returns the data
        return $retData;
    }


    public function deleteDeviceSession(
            $pDeviceId
        , $pEnterpriseId = null
    ){
        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string

        $res = pg_query_params($connectionString,
            "SELECT * FROM delete_device_session(
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
