<?php
/*
 * Authentication Controller
 */

require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/UTCconvertor_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/databaseAdapter_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/idgenerator_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/sqlconnection_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Classes/ActivityClass.php');

class cp_activity_dao{
    public function getActivity(
        $pOwnerId
        , $pDeviceId
        , $pLogId = null
        , $pMessageId = null
        , $pDeviceRelationshipId = null
        , $pLogTitle = null
        , $pLogType = null
        , $pLogStatus = null
        , $pMessageType = null
        , $pMessageTriggerEvent = null
        , $pPageSize = null
        , $pSkipSize = null
        , $pEnterpriseId = null
    ){

        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string

        $res = pg_query_params($connectionString,
            "SELECT * FROM get_activity(
                $1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12
            )"
            , array(
                $pLogId
                , $pMessageId
                , $pDeviceRelationshipId
                , $pOwnerId
                , $pDeviceId
                , $pLogTitle
                , $pLogType
                , $pLogStatus
                , $pMessageType
                , $pMessageTriggerEvent
                , $pPageSize
                , $pSkipSize
            ));
        $data = array();
        $rows = pg_fetch_all($res);

        for($r = 0; $r < count($rows); $r++){
            $row = $rows[$r];
            $activityClass = new cp_Activity();

            $activityClass->activityId = $row["activity_id"];
            $activityClass->logMessage = $row["log_message"];
            $activityClass->logTitle = $row["log_title"];
            $activityClass->logUrl = $row["log_url"];
            $activityClass->logStatus = $row["log_status"];
            $activityClass->logCreateDate = $row["log_create_date"];
            $activityClass->ownerId = $row["owner_id"];
            $activityClass->deviceId = $row["device_id"];
            $activityClass->deviceRelationshipId = $row["device_relationship_id"];
            $activityClass->message = $row["message"];
            $activityClass->messageType = $row["message_type"];
            $activityClass->messageCreateDate = $row["message_create_date"];
            $activityClass->messageTriggerEvent = $row["message_trigger_event"];
            $activityClass->totalRows = $row["total_rows"];

            //add row to table
            array_push($data, $activityClass);
        }

        $rowsRet = pg_num_rows($res);
        $dataAdapter = new cp_databaseAdapter_helper();
        $retData = $dataAdapter->retDataResponse($res, $data, $rowsRet);

        $sqlconnecthelper->dbDisconnect();
        return $retData;
    }
}
 
?>
