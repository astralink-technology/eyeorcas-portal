<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/resData_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/databaseAdapter_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/UTCconvertor_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Dao/activityDao.php');
class cp_ActivityResController
{
    public function getActivities(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        $ownerId = null;
        $deviceId = null;
        $logId = null;
        $messageId = null;
        $deviceRelationshipId = null;
        $logTitle = null;
        $logType = null;
        $logStatus = null;
        $messageType = null;
        $messageTriggerEvent = null;
        $pageSize = null;
        $skipSize = null;
        $enterpriseId = null;

        if (isset($_GET['EnterpriseId'])){ $enterpriseId= $_GET['EnterpriseId']; };
        if (isset($_GET['OwnerId'])){ $ownerId = $_GET['OwnerId']; };
        if (isset($_GET['DeviceId'])){ $deviceId = $_GET['DeviceId']; };
        if (isset($_GET['LogId'])){ $logId= $_GET['LogId']; };
        if (isset($_GET['MessageId'])){ $messageId= $_GET['MessagId']; };
        if (isset($_GET['DeviceRelationshipId'])){ $deviceRelationshipId = $_GET['DeviceRelationshipId']; };
        if (isset($_GET['LogTitle'])){ $logTitle = $_GET['LogTitle']; };
        if (isset($_GET['LogType'])){ $logType = $_GET['LogType']; };
        if (isset($_GET['LogStatus'])){ $logStatus = $_GET['LogStatus']; };
        if (isset($_GET['MessageType'])){ $messageType = $_GET['MessageType']; };
        if (isset($_GET['MessageTriggerEvent'])){ $messageTriggerEvent = $_GET['MessageTriggerEvent']; };
        if (isset($_GET['PageSize'])){ $pageSize = $_GET['PageSize']; };
        if (isset($_GET['SkipSize'])){ $skipSize = $_GET['SkipSize']; };

        //get the json formatted data
        $activityDb = new cp_activity_dao();
        $getActivityRes = $activityDb->getActivity(
            $ownerId
            , $deviceId
            , $logId
            , $messageId
            , $deviceRelationshipId
            , $logTitle
            , $logType
            , $logStatus
            , $messageType
            , $messageTriggerEvent
            , $pageSize
            , $skipSize
            , $enterpriseId
        );

        if ($databaseHelper->hasDataNoError($getActivityRes)){
            $dataResponse->dataResponse($getActivityRes['Data'], $getActivityRes['ErrorCode'], $getActivityRes['ErrorMessage'], $getActivityRes['Error'], $getActivityRes['TotalRowsAvailable']);
        }else{
            $dataResponse->dataResponse(null, $getActivityRes['ErrorCode'], $getActivityRes['ErrorMessage'], $getActivityRes['Error']);
        }
        return;
    }
}
?>
